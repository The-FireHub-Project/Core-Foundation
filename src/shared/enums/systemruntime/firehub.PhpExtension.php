<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.1
 * @package Core\Shared
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Shared\Enums\SystemRuntime;

/**
 * ### PHP extensions enum
 *
 * Provides a list of PHP extensions officially verified and supported by FireHub Core.
 * Serves as a type-safe helper for referencing extension names consistently throughout the framework.
 * This enum is not intended to represent all possible PHP extensions, but only those that FireHub runtime relies on
 * or has tested.
 * @since 1.0.0
 *
 * @api
 */
enum PhpExtension:string {

    /* ================= CORE ================= */

    /**
     * ### Handles fundamental internals like error reporting, variable initialization, output control, and php.ini directive processing
     * @since 1.0.0
     */
    case CORE = 'Core';

    /**
     * ### Supplies functions for date and time manipulation
     * @since 1.0.0
     */
    case DATE = 'date';

    /**
     * ### Implement an interface to the GNU Readline library
     * @since 1.0.0
     */
    case READLINE = 'readline';

    /**
     * ### Reflection API that adds the ability to introspect classes, interfaces, functions, methods, and extensions
     * @since 1.0.0
     */
    case REFLECTION = 'Reflection';

    /**
     * ### The Standard PHP Library (SPL) extension defines interfaces and classes that are meant to solve common
     * problems
     * @since 1.0.0
     */
    case SPL = 'SPL';

    /**
     * ### Provide an interface to the PHP tokenizer embedded in the Zend Engine
     * @since 1.0.0
     */
    case TOKENIZER = 'tokenizer';

    /**
     * ### Encompasses foundational functions
     *
     * Functions like an array_*, string_*, and mathematical utilities (e.g., strlen(), sort()) that form the basis of
     * PHP scripting.
     * @since 1.0.0
     */
    case STANDARD = 'standard';


    /* ================= CRYPTO / SECURITY ================= */

    /**
     * ### Implements a range of one-way hashing algorithms
     * @since 1.0.0
     */
    case HASH = 'hash';

    /**
     * ### The PHP security and cryptography extensions provide essential tools for implementing secure data handling
     * @since 1.0.0
     */
    case OPENSSL = 'openssl';


    /* ================= DATA  / SERIALIZATION ================= */

    /**
     * ### Provides efficient encoding and decoding of JavaScript Object Notation data
     * @since 1.0.0
     */
    case JSON = 'json';


    /* ================= REGEX ================= */

    /**
     * ### Enables an advanced string pattern matching with Perl-like syntax
     * @since 1.0.0
     */
    case PCRE = 'pcre';


    /* ================= RANDOM ================= */

    /**
     * ### Consolidates existing random number generation functions and provides a modern, object-oriented API
     * @since 1.0.0
     */
    case RANDOM = 'random';


    /* ================= PARSING ================= */

    /**
     * ### High-performance, open-source HTML and CSS parser
     * @since 1.0.0
     */
    case LEXBOR = 'lexbor';

    /**
     * ### API for parsing, manipulating, and validating URIs and URLs
     * @since 1.0.0
     */
    case URI = 'uri';


    /* ================= STATE ================= */

    /**
     * ### Manages user sessions for state persistence across requests
     * @since 1.0.0
     */
    case SESSION = 'session';


    /* ================= INPUT / VALIDATION ================= */


    /**
     * ### Offers input validation and sanitization tools
     *
     * Tools such as filter_var(), to clean user data and mitigate risks like cross-site scripting or SQL injection.
     * @since 1.0.0
     */
    case FILTER = 'filter';


    /* ================= STRING / ENCODING ================= */


    /**
     * ### Provides character type-checking functions
     * @since 1.0.0
     */
    case CTYPE = 'ctype';

    /**
     * ### Handles character encoding conversions between formats
     * @since 1.0.0
     */
    case ICONV = 'iconv';

    /**
     * ### Multibyte specific string functions that help you deal with multibyte encodings in PHP
     * @since 1.0.0
     */
    case MBSTRING = 'mbstring';


    /* ================= SAPI / RUNTIME ================= */


    /**
     * ### FPM is a primary PHP FastCGI implementation containing some features (mostly) useful for heavy-loaded sites
     * @since 1.0.0
     */
    case CGI_FCGI = 'cgi-fcgi';


    /* ================= MATH / DATA ================= */


    /**
     * ### For arbitrary precision mathematics which supports amount of any size and precision
     * @since 1.0.0
     */
    case BCMATH = 'bcmath';

    /**
     * ### The calendar presents a series of functions to simplify converting between different calendar formats
     * @since 1.0.0
     */
    case CALENDAR = 'calendar';

    /**
     * ### Provides a simple interface to the GMP library
     * @since 1.0.0
     */
    case GMP = 'gmp';

    /**
     * ### Internationalization extension (further is referred as Intl) is a wrapper for an ICU library
     * @since 1.0.0
     */
    case INTL = 'intl';


    /* ================= DATABASE ================= */


    /**
     * ### The PHP Data Objects extension defines a lightweight, consistent interface for accessing databases
     * @since 1.0.0
     */
    case PDO = 'PDO';

    /**
     * ### Driver that implements the PHP Data Objects (PDO) interface to enable access from PHP to MySQL databases
     * @since 1.0.0
     */
    case PDO_MYSQL = 'pdo_mysql';

    /**
     * ### Driver that implements the PHP Data Objects (PDO) interface to enable access from PHP to PostgreSQL databases
     * @since 1.0.0
     */
    case PDO_PGSQL = 'pdo_pgsql';

    /**
     * ### Driver that implements the PHP Data Objects (PDO) interface to enable access from PHP to SQLite databases
     * @since 1.0.0
     */
    case PDO_SQLITE = 'pdo_sqlite';

    /**
     * ### Driver that implements the PHP Data Objects (PDO) interface to enable access from PHP to Microsoft SQL Server databases
     * @since 1.0.0
     */
    case PDO_SQLSRV = 'pdo_sqlsrv';

    /**
     * ### Driver that implements the PHP Data Objects (PDO) interface to enable access from PHP to Oracle databases
     * @since 1.0.0
     */
    case PDO_OCI = 'pdo_oci';

    /**
     * ### Allows you to access the functionality provided by MySQL 4.1 and above
     * @since 1.0.0
     */
    case MYSQLI = 'mysqli';

    /**
     * ### MySQL Native Driver
     * @since 1.0.0
     */
    case MYSQLND = 'mysqlnd';

    /**
     * ### Provides a set of specific functions to interact with PostgreSQL databases
     * @since 1.0.0
     */
    case PGSQL = 'pgsql';

    /**
     * ### Provides a set of specific functions to interact with SQLite databases
     * @since 1.0.0
     */
    case SQLITE3 = 'sqlite3';

    /**
     * ### Extension lets you access Oracle Database
     * @since 1.0.0
     */
    case OCI8 = 'oci8';

    /**
     * ### Extension provides an interface to Microsoft SQL Server databases
     * @since 1.0.0
     */
    case SQLSRV = 'sqlsrv';

    /**
     * ### MongoDB driver for PHP
     * @since 1.0.0
     */
    case MONGODB = 'mongodb';


    /* ================= XML STACK ================= */


    /**
     * ### List of functions/constants for DOM, libxml, SimpleXML, SOAP, WDDX, XSL, XML, XMLReader, XMLRPC, and XMLWriter
     * @since 1.0.0
     */
    case LIBXML = 'libxml';

    /**
     * ### Provides a very simple and easily usable toolset to convert XML to an object
     * @since 1.0.0
     */
    case SIMPLEXML = 'SimpleXML';

    /**
     * ### Allows operations on XML and HTML documents through the DOM API with PHP
     * @since 1.0.0
     */
    case DOM = 'dom';

    /**
     * ### Basic Expat-based functions
     *
     * For event-driven XML parsing, forming the core toolkit for reading and processing XML streams.
     * @since 1.0.0
     */
    case XML_PARSER = 'xml';

    /**
     * ### Implements a pull-parser for forward-only, memory-efficient traversal of large XML fileS
     * @since 1.0.0
     */
    case XML_READER = 'xmlreader';

    /**
     * ### Supports streaming XML generation with methods for writing elements, attributes, and text
     * @since 1.0.0
     */
    case XML_WRITER = 'xmlwriter';

    /**
     * ### Implements the XSL standard
     * @since 1.0.0
     */
    case XSL = 'xsl';

    /**
     * ### Write SOAP Servers and Clients
     * @since 1.0.0
     */
    case SOAP = 'soap';

    /**
     * ### Functions to write XML-RPC servers and clients
     * @since 1.0.0
     */
    case XMLRPC = 'xmlrpc';

    /**
     * ### Functions are intended for work with WDDX
     * @since 1.0.0
     */
    case WDDX = 'wddx';


    /* ================= NETWORK ================= */


    /**
     * ### Provides an interface to the SSH2 protocol
     *
     * Bindings to the libssh2 library which provide access to resources (shell, remote exec, tunneling, file
     * transfer) on a remote machine using secure cryptographic transport.
     * @since 1.0.0
     */
    case SSH2 = 'ssh2';

    /**
     * ### Connect and communicate to many different types of servers with many different types of protocols
     * @since 1.0.0
     */
    case CURL = 'curl';

    /**
     * ### Provides a way to access FTP servers and manipulate files on them
     * @since 1.0.0
     */
    case FTP = 'ftp';

    /**
     * ### Implements a low-level interface to the socket communication functions based on the popular BSD sockets
     * @since 1.0.0
     */
    case SOCKETS = 'sockets';

    /**
     * ### Provides a way to access and operate with the IMAP, NNTP, POP3 protocols
     * @since 1.0.0
     */
    case IMAP = 'imap';

    /**
     * ### Lightweight Directory Access Protocol, and is a protocol used to access "Directory Servers"
     * @since 1.0.0
     */
    case LDAP = 'ldap';

    /**
     * ### Provides a very simple and easily usable toolset for managing remote devices via the SNMP
     * @since 1.0.0
     */
    case SNMP = 'snmp';


    /* ================= SYSTEM ================= */


    /**
     * ### Contains an interface to those functions defined in the IEEE 1003.1 (POSIX.1) standards
     * @since 1.0.0
     */
    case POSIX = 'posix';

    /**
     * ### Process Control
     *
     * Implements the Unix style of process creation, program execution, signal handling, and process termination.
     * @since 1.0.0
     */
    case PCNTL = 'pcntl';

    /**
     * ### Set of functions that allows PHP to read, write, create, and delete Unix shared memory segments
     * @since 1.0.0
     */
    case SHMOP = 'shmop';

    /**
     * ### Inter-Process Communication (IPC) functions for System V message queues
     *
     * pProvides functions to send and receive System V IPC (Inter-Process Communication) messages, allowing for
     * communication between multiple PHP processes.
     * @since 1.0.0
     */
    case SYSVMSG = 'sysvmsg';

    /**
     * ### System V semaphore functions
     *
     * Provides functions for managing System V semaphores, which are used to synchronize multiple processes and
     * control access to shared resources.
     * @since 1.0.0
     */
    case SYSVSEM = 'sysvsem';

    /**
     * ### Enables support for System V shared memory
     * @since 1.0.0
     */
    case SYSVSHM = 'sysvshm';


    /* ================= RUNTIME / ENGINE ================= */


    /**
     * ### Provides the means to modify constants, user-defined functions, and user-defined classes
     * @since 1.0.0
     */
    case RUNKIT7 = 'runkit7';

    /**
     * ### User Operations for Zend
     * @since 1.0.0
     */
    case UOPZ = 'uopz';

    /**
     * ### Provides a way to call C functions from PHP
     * @since 1.0.0
     */
    case FFI = 'ffi';


    /* ================= ARCHIVE / STREAM ================= */


    /**
     * ### Enables you to transparently read or write ZIP compressed archives and the files inside them
     * @since 1.0.0
     */
    case ZIP = 'zip';

    /**
     * ### Enables you to transparently read or write bzip2 compressed files
     * @since 1.0.0
     */
    case BZ2 = 'bz2';

    /**
     * ### Enables you to transparently read and write gzip (.gz) compressed files
     * @since 1.0.0
     */
    case ZLIB = 'zlib';

    /**
     * ### Provides a way to put entire PHP applications into a single file called a "phar" (PHP Archive)
     * @since 1.0.0
     */
    case PHAR = 'Phar';


    /* ================= SECURITY ================= */


    /**
     * ### Library for encryption, decryption, signatures, password hashing
     * @since 1.0.0
     */
    case SODIUM = 'sodium';


    /* ================= CACHE / PERFORMANCE ================= */


    /**
     * ### Improves performance by storing pre-compiled script bytecode in shared memory
     * @since 1.0.0
     */
    case ZEND_OPCACHE = 'Zend OPcache';

    /**
     * ### In-memory key-value store
     * @since 1.0.0
     */
    case APCU = 'apcu';

    /**
     * ### High-performance, distributed memory object caching system
     * @since 1.0.0
     */
    case MEMCACHED = 'memcached';

    /**
     * ### Interfacing with key-value stores
     * @since 1.0.0
     */
    case REDIS = 'redis';


    /* ================= DEBUG / PROFILING ================= */


    /**
     * ### Provides a range of features to improve the PHP development experience
     * @since 1.0.0
     */
    case XDEBUG = 'xdebug';

    /**
     * ### Profiling tool that allows you to measure the execution time of PHP scripts
     * @since 1.0.0
     */
    case PCOV = 'pcov';


    /* ================= IMAGING ================= */


    /**
     * ### Create and manipulate image files in a variety of different image formats
     * @since 1.0.0
     */
    case GD = 'gd';

    /**
     * ### Create and modify images using the ImageMagick library
     * @since 1.0.0
     */
    case IMAGICK = 'imagick';

    /**
     * ### Ability to work with image meta-data
     * @since 1.0.0
     */
    case EXIF = 'exif';


    /* ================= MESSAGING / ASYNC ================= */


    /**
     * ### Communicate with any AMQP compliant server
     * @since 1.0.0
     */
    case AMQP = 'amqp';

    /**
     * ### Kafka client based on librdkafka
     * @since 1.0.0
     */
    case RDKAFKA = 'rdkafka';

    /**
     * ### Efficiently schedule I/O, time, and signal based events using the best I/O notification
     * @since 1.0.0
     */
    case EVENT = 'event';

    /**
     * ### Google's language-neutral, platform-neutral, extensible mechanism for serializing structured data
     * @since 1.0.0
     */
    case PROTOBUF = 'protobuf';

    /**
     * ### A high-performance, open-source, general RPC framework that puts mobile and HTTP/2 first
     * @since 1.0.0
     */
    case GRPC = 'grpc';


    /* ================= EVENT ================= */


    /**
     * ### Event-driven asynchronous and concurrent networking engine with high performance for PHP
     * @since 1.0.0
     */
    case SWOOLE = 'swoole';


    /* ================= UTILITIES ================= */


    /**
     * ### Implements the YAML Ain't Markup Language (YAML) data serialization standard
     * @since 1.0.0
     */
    case YAML = 'yaml';

    /**
     * ### UUID extension
     * @since 1.0.0
     */
    case UUID = 'uuid';

    /**
     * ### GEO IP extension allows you to determine the geographical location of an IP address
     *
     * Find the location of an IP address. City, State, Country, Longitude, Latitude, and other information as all,
     * such as ISP and connection type can be obtained with the help of GeoIP.
     * @since 1.0.0
     *
     * @warning This extension does not support MaxMind's current "GeoIP2" databases, only the "GeoIP legacy"
     * database files.
     */
    case GEOIP = 'geoip';

}