<?php

declare(strict_types=1);

namespace lib;

/**
 * Socket :: FeBe - Framework
 */
abstract class Socket {

    /**
     * socketClient
     *
     * @param  string $host
     * @param  string $port
     */
    public static function socketClient(string $host = 'localhost', string $port = '80') {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($socket, $host, $port);
        $message = "Hallo Server";
        socket_write($socket, $message, strlen($message));
        $message = socket_read($socket, 1024);
        echo "Nachricht vom Server: $message\n";
        socket_close($socket);
    }
   
    /**
     * socketServer
     *
     * @param  string $host
     * @param  string $port
     */
    public static function socketServer(string $host = 'localhost', string $port = '80') {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_bind($socket, $host, $port);
        socket_listen($socket);
        while (true) {
            // Akzeptiert eine Verbindung
            $client = socket_accept($socket);
            // Liest die Nachricht vom Client
            $message = socket_read($client, 1024);
            echo "Nachricht erhalten: $message\n";
            // Antwort an den Client senden
            socket_write($client, "Nachricht erhalten");
            // Schließt die Verbindung
            socket_close($client);
        }
    }

}