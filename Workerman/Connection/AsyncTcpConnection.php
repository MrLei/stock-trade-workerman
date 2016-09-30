<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Workerman\Connection;

use Workerman\Events\EventInterface;
use Workerman\Worker;
use Exception;

/**
 * AsyncTcpConnection.
 */
class AsyncTcpConnection extends TcpConnection
{
    /**
     * Emitted when socket connection is successfully established.
     *
     * @var callback
     */
    public $onConnect = null;

    /**
     * Status.
     *
     * @var int
     */
    protected $_status = self::STATUS_CONNECTING;

    /**
     * Remote host.
     *
     * @var string
     */
    protected $_remoteHost = '';

    /**
     * Construct.
     *
     * @param string $remote_address
     * @throws Exception
     */
    public function __construct($remote_address)
    {
        list($scheme, $address) = explode(':', $remote_address, 2);
        if ($scheme != 'tcp') {
            // Get application layer protocol.
            $scheme         = ucfirst($scheme);
            $this->protocol = '\\Protocols\\' . $scheme;
            if (!class_exists($this->protocol)) {
                $this->protocol = '\\Workerman\\Protocols\\' . $scheme;
                if (!class_exists($this->protocol)) {
                    throw new Exception("class \\Protocols\\$scheme not exist");
                }
            }
        }
        $this->_remoteAddress = substr($address, 2);
        $this->_remoteHost    = substr($this->_remoteAddress, 0, strrpos($this->_remoteAddress, ':'));
        $this->id             = self::$_idRecorder++;
        // For statistics.
        self::$statistics['connection_count']++;
        $this->maxSendBufferSize = self::$defaultMaxSendBufferSize;
    }

    public function connect()
    {
        // Open socket connection asynchronously.
        $this->_socket = stream_socket_client("tcp://{$this->_remoteAddress}", $errno, $errstr, 0,
            STREAM_CLIENT_ASYNC_CONNECT);
        // If failed attempt to emit onError callback.
        if (!$this->_socket) {
            $this->_status = self::STATUS_CLOSED;
            $this->emitError(WORKERMAN_CONNECT_FAIL, $errstr);
            return;
        }
        // Add socket to global event loop waiting connection is successfully established or faild. 
        Worker::$globalEvent->add($this->_socket, EventInterface::EV_WRITE, array($this, 'checkConnection'));
    }

    /**
     * Get remote address.
     *
     * @return string 
     */
    public function getRemoteHost()
    {
        return $this->_remoteHost;
    }

    /**
     * Try to emit onError callback.
     *
     * @param int    $code
     * @param string $msg
     * @return void
     */
    protected function emitError($code, $msg)
    {
        if ($this->onError) {
            try {
                call_user_func($this->onError, $this, $code, $msg);
            } catch (\Exception $e) {
                echo $e;
                exit(250);
            } catch (\Error $e) {
                echo $e;
                exit(250);
            }
        }
    }

    /**
     * Check connection is successfully established or faild.
     *
     * @param resource $socket
     * @return void
     */
    public function checkConnection($socket)
    {
        // Check socket state.
        if (stream_socket_get_name($socket, true)) {
            // Remove write listener.
            Worker::$globalEvent->del($socket, EventInterface::EV_WRITE);
            // Nonblocking.
            stream_set_blocking($socket, 0);
            // Try to open keepalive for tcp and disable Nagle algorithm.
            if (function_exists('socket_import_stream')) {
                $raw_socket = socket_import_stream($socket);
                socket_set_option($raw_socket, SOL_SOCKET, SO_KEEPALIVE, 1);
                socket_set_option($raw_socket, SOL_TCP, TCP_NODELAY, 1);
            }
            // Register a listener waiting read event.
            Worker::$globalEvent->add($socket, EventInterface::EV_READ, array($this, 'baseRead'));
            // There are some data waiting to send.
            if ($this->_sendBuffer) {
                Worker::$globalEvent->add($socket, EventInterface::EV_WRITE, array($this, 'baseWrite'));
            }
            $this->_status        = self::STATUS_ESTABLISH;
            $this->_remoteAddress = stream_socket_get_name($socket, true);
            // Try to emit onConnect callback.
            if ($this->onConnect) {
                try {
                    call_user_func($this->onConnect, $this);
                } catch (\Exception $e) {
                    echo $e;
                    exit(250);
                } catch (\Error $e) {
                    echo $e;
                    exit(250);
                }
            }
        } else {
            // Connection failed.
            $this->emitError(WORKERMAN_CONNECT_FAIL, 'connect fail');
            $this->destroy();
            $this->onConnect = null;
        }
    }
}
