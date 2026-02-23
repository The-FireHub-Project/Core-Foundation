<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.1
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Shared\Enums\ {
    Order, FileSystem\Permission
};
use FireHub\Core\Throwable\Error\LowLevel\FileSystem\ {
    CannotListError, ChangeSymlinkGroupError, ChangeSymlinkOwnerError, CopyPathError, CreateFolderError,
    CreateLinkError, CreateSymlinkError, DeletePathError, DiskSpaceError, GetAbsolutePathError, GetContentError,
    GetGroupError, GetInodeError, GetLastAccessedError, GetLastChangedError, GetLastModifiedError, GetOwnerError,
    GetPathSizeError, GetPermissionsError, GetStatisticsError, GetSymlinkError, MoveUploadedFileError,
    ParentLevelTooSmallError, PathDoesntExistError, PutContentError, ReadFileError, RenameError, SearchError,
    SetGroupError, SetLastAccessAndModifyError, SetOwnerError, SetPermissionsError
};

use const FireHub\Core\Shared\Constants\Path\DS;
use const FILE_APPEND;
use const FILE_IGNORE_NEW_LINES;
use const FILE_SKIP_EMPTY_LINES;
use const GLOB_ONLYDIR;
use const LOCK_EX;
use const SCANDIR_SORT_ASCENDING;
use const SCANDIR_SORT_DESCENDING;
use const SCANDIR_SORT_NONE;

use function basename;
use function chgrp;
use function chmod;
use function chown;
use function clearstatcache;
use function copy;
use function dirname;
use function disk_free_space;
use function disk_total_space;
use function file;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function fileatime;
use function filectime;
use function filegroup;
use function fileinode;
use function filemtime;
use function fileowner;
use function fileperms;
use function filesize;
use function glob;
use function is_dir;
use function is_executable;
use function is_file;
use function is_uploaded_file;
use function is_link;
use function is_readable;
use function is_writable;
use function lchgrp;
use function lchown;
use function link;
use function lstat;
use function mkdir;
use function move_uploaded_file;
use function pathinfo;
use function readfile;
use function readlink;
use function realpath;
use function rename;
use function rmdir;
use function symlink;
use function scandir;
use function stat;
use function touch;
use function unlink;

/**
 * ### FileSystem Low-Level Utility
 *
 * Provides a set of low-level, fail-fast operations for working with files and directories. This class is intended
 * for internal/core usage, offering type-safe and predictable methods for reading, writing, checking existence,
 * creating, and deleting filesystem resources.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class FileSystem extends LowLevel {

    /**
     * ### Checks whether a file or folder exists
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file or folder.
     * </p>
     *
     * @return bool True if the file or directory specified by filename exists, false otherwise.
     *
     * @note Because PHP's integer type is signed and many platforms use 32bit integers, some filesystem functions
     * may return unexpected results for files which are larger than 2GB.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     * @tip On Windows, use //computer_name/share/filename or \\computer_name\share\filename to check files on network
     * shares.
     */
    public static function exist (string $path):bool {

        return file_exists($path);

    }

    /**
     * ### Tells whether a file exists and is readable
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file or folder.
     * </p>
     *
     * @return bool True if the file or directory specified by $path exists and is readable, false otherwise.
     *
     * @note The check is done using the real UID/GID instead of the effective one.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function isReadable (string $path):bool {

        return is_readable($path);

    }

    /**
     * Tells whether the path is writable
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     *
     * @return bool True if the filename exists and is writable.
     *
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function isWritable (string $path):bool {

        return is_writable($path);

    }

    /**
     * ### Tells whether the path is a symbolic link
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     *
     * @return bool True if the filename exists and is a symbolic link, false otherwise.
     *
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function isSymbolicLink (string $path):bool {

        return is_link($path);

    }

    /**
     * ### Tells whether the path is a regular file
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     *
     * @return bool True if the filename exists and is a regular file, false otherwise.
     *
     * @note Because PHP's integer type is signed and many platforms use 32bit integers, some filesystem functions
     * may return unexpected results for files which are larger than 2GB.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function isFile (string $path):bool {

        return is_file($path);

    }

    /**
     * ### Tells whether the filename is a regular folder
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the folder.<br>
     * If the filename is a relative filename, it will be checked relative to the current working folder.<br>
     * If the filename is a symbolic or hard link, then the link will be resolved and checked.<br>
     * If you've enabled open_basedir, further restrictions may apply.
     * </p>
     *
     * @return bool True if the filename exists and is a regular folder, false otherwise.
     *
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function isFolder (string $path):bool {

        return is_dir($path);

    }

    /**
     * ### Tells whether the path is executable
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     *
     * @return bool True if the filename exists and is an executable file, false otherwise.
     *
     * @note On POSIX systems, a file is executable if the executable bit of the file permissions is set.<br>
     * On Windows, a file is considered executable if it is a properly executable file as reported by the Win API
     * GetBinaryType(); for BC reasons, files with a .bat or .cmd extension are also considered executable.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function isExecutable (string $path):bool {

        return is_executable($path);

    }

    /**
     * ### Tells whether the file was uploaded via HTTP POST
     *
     * Returns true if the file named by filename was uploaded via HTTP POST.<br>
     * This is useful to help ensure that a malicious user hasn't tried to trick the script into working on files
     * upon which it shouldn't be working.<br>
     * This sort of check is especially important if there is any chance that anything done with uploaded files could
     * reveal their contents to the user, or even to other users on the same system.<br>
     * For proper working, the function File#isUploaded() needs an argument like $_FILES['userfile']['tmp_name'],
     * – the name of the uploaded file on the client's machine $_FILES['userfile']['name'] doesn't work.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     *
     * @return bool True on success or false on failure.
     */
    public static function isUploaded (string $path):bool {

        return is_uploaded_file($path);

    }

    /**
     * ### Renames a file or directory
     *
     * Attempts to rename $path to $new_name, moving it between directories if necessary.<br>
     * If renaming a file and $new_name exists, it will be overwritten.<br>
     * If renaming a directory and $new_name exists, this function will emit a warning.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\FileSystem::parent() To return a parent folder path.
     * @uses \FireHub\Core\Shared\Constants\Path\DS To separate folders.
     *
     * @param non-empty-string $path <p>
     * The old name path.
     * </p>
     * @param non-empty-string $new_name <p>
     * The new name.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\RenameError If we couldn't rename a path.
     *
     * @return true True on success.
     *
     * @note On Windows, if $new_name already exists, it must be writable, otherwise FileSystem#rename() fails and
     * issues E_WARNING.
     */
    public static function rename (string $path, string $new_name):true {

        return rename($path, self::parent($path).DS.$new_name)
            ?: throw new RenameError;

    }

    /**
     * ### Copies file
     *
     * Makes a copy of the file $path to $to.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Constants\Path\DS To separate folders.
     * @uses \FireHub\Core\Support\LowLevel\File::basename() To get a base name component of $to a path.
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     * @param non-empty-string $to <p>
     * The destination path.<br>
     * If dest is a URL, the copy operation may fail if the wrapper doesn't support overwriting of existing files.<br>
     * If the destination file already exists, it will be overwritten.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CopyPathError If we couldn't copy a file.
     *
     * @return true True on success.
     *
     * @warning If the destination file already exists, it will be overwritten.
     */
    public static function copy (string $path, string $to):true {

        return copy($path, $to.DS.self::basename($path))
            ?: throw new CopyPathError();

    }

    /**
     * ### Makes folder
     *
     * Attempts to create the folder specified by $path.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\FileSystem\Permission As parameter.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::int() To find whether octdec() returns an integer.
     *
     * @param non-empty-string $path <p>
     * Path to folder ot disk partition.
     * </p>
     * @param \FireHub\Core\Shared\Enums\FileSystem\Permission $owner <p>
     * File owner permission.
     * </p>
     * @param \FireHub\Core\Shared\Enums\FileSystem\Permission $owner_group <p>
     * File owner group permission.
     * </p>
     * @param \FireHub\Core\Shared\Enums\FileSystem\Permission $global <p>
     * Everyone's permission.
     * </p>
     * @param bool $recursive [optional] <p>
     * If true, then any parent folders to the $path specified will also be created, with the same permissions.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CreateFolderError If we couldn't create a folder.
     *
     * @return true True on success.
     *
     * @todo Replace octdec with low level class.
     */
    public static function create (string $path, Permission $owner, Permission $owner_group, Permission $global, bool $recursive = false):true {

        return mkdir($path, (int)octdec('0'.$owner->value.$owner_group->value.$global->value), $recursive)
            ?: throw new CreateFolderError;

    }

    /**
     * ### Deletes folder
     *
     * Attempts to remove the folder named by $path.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to folder.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\DeletePathError If we couldn't delete the folder.
     *
     * @return true True on success.
     */
    public static function deleteFolder (string $path):true {

        return rmdir($path)
            ?: throw new DeletePathError;

    }

    /**
     * ### Deletes a file
     *
     * Attempts to remove the folder named by $path.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\DeletePathError If we couldn't delete the file.
     *
     * @return true True on success.
     */
    public static function deleteFile (string $path):true {

        return unlink($path)
            ?: throw new DeletePathError;

    }

    /**
     * ### Create a hard link
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     * @param non-empty-string $link <p>
     * The link name.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CreateLinkError If we couldn't create a hard link
     * for a path.
     *
     * @return true True on success.
     *
     * @note This function will not work on remote files as the file to be examined must be accessible via
     * the server's filesystem.
     * @note For Windows only: This function requires PHP to run in an elevated mode or with the UAC disabled.
     */
    public static function link (string $path, string $link):true {

        return link($path, $link)
            ?: throw new CreateLinkError;

    }

    /**
     * ### Returns a trailing name component of a path
     *
     * Given a string containing the path to a file or directory, this function will return the trailing name component.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * A path. On Windows, both slash (/) and backslash (\) are used as directory separator characters.<br>
     * In other environments, it is the forward slash (/).
     * </p>
     * @param string $suffix [optional] <p>
     * If the name component ends in suffix, this will also be cut off.
     * </p>
     *
     * @return string The base name of the given path.
     *
     * @caution Method is locale-aware, so for it to see the correct basename with multibyte character paths,
     * the matching locale must be set using the setlocale() function.<br>
     * If a path contains characters which are invalid for the current locale, the behavior of
     * FileSystem#basename() is undefined.
     * @note Method operates naively on the input string and is not aware of the actual filesystem or path
     * components such as "..".
     */
    public static function basename (string $path, string $suffix = ''):string {

        return basename($path, $suffix);

    }

    /**
     * ### Returns information about a file path
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * The path to be parsed.
     * </p>
     *
     * @return array{
     *   'dirname': string|false,
     *   'basename': string|false,
     *   'extension': string|false,
     *   'filename': string|false
     * } Information about a file path.
     *
     * @caution FileSystem#pathInfo() is locale-aware, so for it to parse a path containing multibyte characters
     * correctly, the matching locale must be set using the setlocale() function.
     * @note FileSystem#pathInfo() operates naively on the input string and is not aware of the actual filesystem,
     * or path components such as "..".
     * @note On Windows systems only, the \ character will be interpreted as a directory separator.<br>
     * On other systems it will be treated like any other character.
     */
    public static function pathInfo (string $path):array {

        $path_info = pathinfo($path);

        return [
            'dirname' => $path_info['dirname'] ?? false,
            'basename' => $path_info['basename'] ?? false,
            'extension' => $path_info['extension'] ?? false,
            'filename' => $path_info['filename'] ?? false
        ];

    }

    /**
     * ### Returns canonical absolute pathname
     *
     * Expands all symbolic links and resolves references to /./, /../ and extra / characters in the input path and
     * returns the canonical absolute pathname.<br>
     * Trailing delimiters, such as \ and /, are also removed.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * The path being checked.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetAbsolutePathError If we couldn't get an absolute
     * path for a path or file doesn't exist, or a script doesn't have executable permissions.
     *
     * @return non-empty-string The canonical absolute pathname.
     *
     * @note Whilst a path must be supplied, the value can be an empty string.<br>
     * In this case, the value is interpreted as the current directory.
     * @note The running script must have executable permissions in all directories in the hierarchy, otherwise
     * FileSystem#absolutePath() will return false.
     * @note For case-insensitive filesystems, absolutePath() may or may not normalize the character case.
     * @note The function FileSystem#absolutePath() will not work for a file which is inside a Phar as such a path
     * would be virtual path, not a real one.
     * @note On Windows, one level only expands junctions and symbolic links to directories.
     * @note Because PHP's integer type is signed and many platforms use 32bit integers, some filesystem functions
     * may return unexpected results for files which are larger than 2GB.
     */
    public static function absolutePath (string $path):string {

        return realpath($path)
            ?: throw new GetAbsolutePathError;

    }

    /**
     * ### Returns parent folder path
     *
     * Given a string containing the path of a file or directory, this function will return the parent folder's path
     * that is levels up from the current folder.
     * @since 1.0.0
     *
     * @param string $path <p>
     * A path.
     * </p>
     * @param positive-int $levels [optional] <p>
     * The number of parent folders to go up.
     * This must be an integer greater than 0.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\ParentLevelTooSmallError If $levels are less than 1.
     *
     * @return string The parent folder name of the given path.
     * If there are no slashes in a path, a dot is returned, indicating the current folder.
     *
     * @caution Be careful when using this function in a loop that can reach the top-level directory as this can
     * result in an infinite loop.
     */
    public static function parent (string $path, int $levels = 1):string {

        return $levels >= 1
            ? dirname($path, $levels)
            : throw new ParentLevelTooSmallError;

    }

    /**
     * ### Gets file size
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetPathSizeError If we couldn't get file size for
     * a file.
     *
     * @return non-negative-int The size of the file in bytes.
     *
     * @note Because PHP's integer type is signed and many platforms use 32bit integers, some filesystem functions
     * may return unexpected results for files which are larger than 2GB.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function size (string $path):int {

        return ($size = filesize($path)) !== false
            ? $size : throw new GetPathSizeError;

    }

    /**
     * ### List files and folders inside the specified folder
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Order::ASC To list files and folders in ascending order.
     * @uses \FireHub\Core\Shared\Enums\Order::DESC To list files and folders in descending order.
     *
     * @param non-empty-string $folder <p>
     * The folder that will be scanned.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\Order $order [optional] <p>
     * Result order.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CannotListError If $folder is empty, or we couldn't
     * list files and directories inside the specified folder.
     *
     * @return list<string> An array of filenames.
     */
    public static function list (string $folder, ?Order $order = null):array {

        return scandir($folder, match ($order) {
            Order::ASC => SCANDIR_SORT_ASCENDING,
            Order::DESC => SCANDIR_SORT_DESCENDING,
            default => SCANDIR_SORT_NONE
        }) ?: throw new CannotListError;

    }

    /**
     * ### Find path-names matching a pattern
     *
     * This method searches for all the path-names matching patterns according to the rules used by the libc glob()
     * function, which is similar to the rules used by common shells.
     * @since 1.0.0
     *
     * @param non-empty-string $pattern <p>
     * The pattern.<br>
     * No tilde expansion or parameter substitution is done.
     * - * – Matches zero or more characters.
     * - ? – Matches exactly one character (any character).
     * - [...] – Matches one character from a group of characters. If the first character is !, matches any character
     * not in the group.
     * - \ – Escapes the following character.
     * </p>
     * @param bool $only_folders [optional] <p>
     * Return only directory entries which match the pattern.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SearchError If there was an error while searching
     * for a path.
     *
     * @return list<string> An array containing the matched files/folders, an empty array if no file matched.
     *
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     * @note This function isn't available on some systems (for example, old Sun OS).
     */
    public static function search (string $pattern, bool $only_folders = false):array {

        return ($glob = glob($pattern, $only_folders ? GLOB_ONLYDIR : 0)) !== false
            ? $glob : throw new SearchError;

    }

    /**
     * ### Gets a file or folder group
     *
     * Gets the file or folder group. The group ID is returned in numerical format.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path of the file or folder.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetGroupError If we couldn't get a group for a file.
     *
     * @return int The group ID of the file.
     *
     * @warning This method doesn't work on Windows.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     * @tip Use posix_getgrgid() to resolve it to a group name.
     */
    public static function getGroup (string $path):int {

        return ($group = filegroup($path)) === false
            ? throw new GetGroupError
            : $group;

    }

    /**
     * ### Changes file or folder group
     *
     * Attempts to change the group of the files or folder $path to $group.<br>
     * Only the superuser may change the group of files arbitrarily; other users may change the group of files to any
     * group of which that user is a member.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path of the file or folder.
     * </p>
     * @param non-empty-string|int $group <p>
     * A group name or number.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SetGroupError If we couldn't set a group for file
     * or folder.
     *
     * @return true True on success.
     *
     * @warning This method doesn't work on Windows.
     * @tip Use posix_getgrgid() to resolve it to a group name.
     */
    public static function setGroup (string $path, string|int $group):true {

        return chgrp($path, $group)
            ?: throw new SetGroupError;

    }

    /**
     * ### Gets file or folder owner
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path of the file or folder.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetOwnerError If we couldn't get an owner for a file or
     * folder.
     *
     * @return int The user ID of the owner for the file or folder.
     *
     * @warning This method doesn't work on Windows.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     * @tip Use posix_getpwuid() to resolve it to a username.
     */
    public static function getOwner (string $path):int {

        return ($owner = fileowner($path)) === false
            ? throw new GetOwnerError
            : $owner;

    }

    /**
     * ### Gets file or folder owner
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Pth of the file or folder.
     * </p>
     * @param non-empty-string|int $user <p>
     * A username or number.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SetOwnerError If we couldn't get an owner for a file
     * or folder.
     *
     * @return true True on success.
     *
     * @warning This method doesn't work on Windows.
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     * @tip Use posix_getpwuid() to resolve it to a username.
     */
    public static function setOwner (string $path, string|int $user):true {

        return chown($path, $user)
            ?: throw new SetOwnerError;

    }

    /**
     * ### Gets path permissions
     *
     * Gets permissions for the given path.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\StrSB::part() To get part of the decoct() function.
     *
     * @param non-empty-string $path <p>
     * The path.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetPermissionsError If we couldn't get permissions for
     * a path.
     *
     * @return numeric-string Path permissions.
     *
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     *
     * @todo Replace decoct with low level class.
     */
    public static function getPermissions (string $path):string {

        /** @var numeric-string */
        return ($permissions = fileperms($path)) === false
            ? throw new GetPermissionsError
            : StrSB::part(decoct($permissions), -4); // @phpstan-ignore argument.type

    }

    /**
     * ### Sets path permissions
     *
     * Attempts to change the mode of the specified path to that given in permissions.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\FileSystem\Permission As parameter.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::int() To find whether octdec returns integer.
     *
     * @param non-empty-string $path <p>
     * The path.
     * </p>
     * @param \FireHub\Core\Shared\Enums\FileSystem\Permission $owner <p>
     * File owner permission.
     * </p>
     * @param \FireHub\Core\Shared\Enums\FileSystem\Permission $owner_group <p>
     * File owner group permission.
     * </p>
     * @param \FireHub\Core\Shared\Enums\FileSystem\Permission $global <p>
     * Everyone's permission.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SetPermissionsError If we couldn't set permissions for
     * a path.
     *
     * @return True Only true.
     *
     * @note The current user is the user under which PHP runs.<br>
     * It is probably different from the user you use for normal shell or FTP access.
     * The mode can be changed only by the user who owns the file on most systems.
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     *
     * @todo Replace octdec with low level class.
     */
    public static function setPermissions (string $path, Permission $owner, Permission $owner_group, Permission $global):true {

        return chmod($path, (int)octdec('0'.$owner->value.$owner_group->value.$global->value))
            ?: throw new SetPermissionsError;

    }

    /**
     * ### Gets last access time of path
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to file or folder.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetLastAccessedError If we couldn't get last accessed
     * time for a path.
     *
     * @return int The time the file was last accessed (the time is returned as a Unix timestamp).
     *
     * @note The atime of a file is supposed to change whenever the data blocks of a file are being read.<br>
     * This can be costly performance-wise when an application regularly accesses a huge number of files or
     * directories.<br>
     * Some Unix filesystems can be mounted with atime updates disabled to increase the performance of such
     * applications; USENET news spools are a common example.<br>
     * On such filesystems this function will be useless.
     * @note Note that time resolution may differ from one file system to another.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function lastAccessed (string $path):int {

        return ($time = fileatime($path)) !== false
            ? $time : throw new GetLastAccessedError;

    }

    /**
     * ### Gets last modification time of a path
     *
     * Represents when the data or content is changed or modified, not including that of metadata such as ownership or
     * owner group.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to file or folder.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetLastModifiedError If we couldn't get the last
     * modified time for a path.
     *
     * @return int The time the file was last modified (the time is returned as a Unix timestamp).
     *
     * @note Note that time resolution may differ from one file system to another.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function lastModified (string $path):int {

        return ($time = filemtime($path)) !== false
            ? $time : throw new GetLastModifiedError;

    }

    /**
     * ### Gets inode change time of a path
     *
     * Represents the time when the metadata or inode data of a file is altered, such as the change of permissions,
     * ownership, or group.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to file or folder.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetLastChangedError If we couldn't get last changed
     * time for a path.
     *
     * @return int The time the file was last changed (the time is returned as a Unix timestamp).
     *
     * @note In most Unix filesystems, a file is considered changed when its inode data is changed; that is, when the
     * permissions, owner, group, or other metadata from the inode is updated.<br>
     * See also FileSystem#lastModified() (which is what you want to use when you want to create "Last Modified"
     * footers on web pages) and FileSystem#lastAccessed().
     * @note On Windows, this function will return creating time but on UNIX inode change time.
     * @note Note that time resolution may differ from one file system to another.
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function lastChanged (string $path):int {

        return ($time = filectime($path)) !== false
            ? $time : throw new GetLastChangedError;

    }

    /**
     * ### Sets last access and modification time of a path
     *
     * Attempts to set the access and modification times of the file named in the filename parameter to the value
     * given in mtime. Note that the access time is always modified, regardless of the number of parameters.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to file or folder.
     * </p>
     * @param null|int $last_accessed [optional] <p>
     * The touch time.<br>
     * If mtime is null, the current system time() is used.
     * </p>
     * @param null|int $last_modified [optional] <p>
     * If not null, the access time of the given filename is set to the value of atime.<br>
     * Otherwise, it is set to the value passed to the mtime parameter.<br>
     * If both are null, the current system time is used.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SetLastAccessAndModifyError If we couldn't set the last
     * access and modification time of a path.
     *
     * @return true True on success.
     *
     * @note If the file doesn't exist, it will be created.
     * @note Note that time resolution may differ from one file system to another.
     */
    public static function setLastAccessedAndModification (string $path, ?int $last_accessed = null, ?int $last_modified = null):true {

        return touch($path, $last_modified, $last_accessed)
            ?: throw new SetLastAccessAndModifyError;

    }


    /**
     * ### Gets file inode
     *
     * Inode are special disk blocks they are created when the file system is created.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to file or folder.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetInodeError If we don't get inode for a path.
     *
     * @return int The inode number of the file.
     *
     * @note The results of this function are cached.<br>
     * See FileSystem#clearCache() for more details.
     */
    public static function inode (string $path):int {

        return fileinode($path)
            ?: throw new GetInodeError;

    }

    /**
     * ### Creates a symbolic link
     *
     * Creates a symbolic link to the existing $path with the specified name $link.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the symlink.
     * </p>
     * @param non-empty-string $link <p>
     * The link name.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CreateSymlinkError If we couldn't create symlink for
     * a path with a link.
     *
     * @return true True on success.
     */
    public static function symlink (string $path, string $link):true {

        return symlink($path, $link)
            ?: throw new CreateSymlinkError;

    }

    /**
     * ### Returns the target of a symbolic link
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the symlink.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetSymlinkError If we couldn't symlink target for
     * a path.
     *
     * @return string The contents of the symbolic link path.
     */
    public function getSymlink (string $path):string {

        return readlink($path)
            ?: throw new GetSymlinkError;

    }

    /**
     * ### Changes group ownership of symlink
     *
     * Attempts to change the group of the symlink filenames to group.<br>
     * Only the superuser may change the group of symlinks arbitrarily.<br>
     * Other users may change the group of symlinks to any group of which that user is a member.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the symlink.
     * </p>
     * @param non-empty-string|int $group <p>
     * The group is specified by name or number.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\ChangeSymlinkGroupError If we couldn't change a
     * symlink group.
     *
     * @return true True on success.
     *
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     * @note This function is not implemented on Windows platforms.
     * @tip Use posix_getgrgid() to resolve it to a group name.
     */
    public static function symlinkGroup (string $path, string|int $group):true {

        return lchgrp($path, $group)
            ?: throw new ChangeSymlinkGroupError;

    }

    /**
     * ### Changes user ownership of symlink
     *
     * Attempts to change the owner of the symlink $path to user $user.<br>
     * Only the superuser may change the owner of a symlink.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the symlink.
     * </p>
     * @param non-empty-string|int $user <p>
     * Username or number.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\ChangeSymlinkOwnerError If we couldn't change symlink
     * ownership.
     *
     * @return true True on success.
     *
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     * @note This function is not implemented on Windows platforms.
     * @tip Use posix_getpwuid() to resolve it to a username.
     */
    public static function symlinkOwner (string $path, string|int $user):true {

        return lchown($path, $user)
            ?: throw new ChangeSymlinkOwnerError;

    }

    /**
     * ### Gives information about a file or folder
     *
     * Gathers the statistics of the file named by filename.<br>
     * If the filename is a symbolic link, statistics are from the file itself, not the symlink – use $symlink
     * argument to change that behavior.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::filter() To filter string keys in statistics.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::string() To find whether the statistics key is string or not.
     *
     * @param non-empty-string $path <p>
     * Path to the file or folder.
     * </p>
     * @param bool $symlink [optional] <p>
     * If true, the method gives information about a file or symbolic link.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetStatisticsError If we couldn't get statistics for
     * a path.
     *
     * @return array{
     *   dev: int,
     *   ino: int,
     *   mode: int,
     *   nlink: int,
     *   uid: int,
     *   gid: int,
     *   rdev: int,
     *   size: int,
     *   atime: int,
     *   mtime: int,
     *   ctime: int,
     *   blksize: int,
     *   blocks: int
     * } Statistics about a file or folder.
     */
    public static function statistics (string $path, bool $symlink = false):array {

        /** @var array{
         *   dev: int,
         *   ino: int,
         *   mode: int,
         *   nlink: int,
         *   uid: int,
         *   gid: int,
         *   rdev: int,
         *   size: int,
         *   atime: int,
         *   mtime: int,
         *   ctime: int,
         *   blksize: int,
         *   blocks: int
         * }
         */
        return Arr::filter(
            ($statistics = $symlink ? lstat($path) : stat($path)) !== false
                ? $statistics
                : throw new GetStatisticsError,
            static fn(int $value, int|string $key) => DataIs::string($key)
        );

    }

    /**
     * ### Outputs a file
     *
     * Reads a file and writes it to the output buffer.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * The filename path being read.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\ReadFileError If we couldn't put a read file on a path,
     * or a path is empty.
     *
     * @return non-negative-int The number of bytes read from the file.
     *
     * @note File#read() will not present any memory issues, even when sending large files, on its own.<br>
     * If you encounter an out-of-memory error, ensures that output buffering is off with ob_get_level().
     */
    public static function read (string $path):int {

        return readfile($path)
            ?: throw new ReadFileError;

    }

    /**
     * ### Moves an uploaded file to a new location
     *
     * This function checks to ensure that the file designated by $from is a valid upload file (meaning that it was
     * uploaded via PHP's HTTP POST upload mechanism).<br>
     * If the file is valid, it will be moved to the filename given by $to.
     * @since 1.0.0
     *
     * @param non-empty-string $from <p>
     * Filename of the uploaded file.
     * </p>
     * @param non-empty-string $to <p>
     * Destination of the moved file.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\MoveUploadedFileError If we couldn't move the uploaded
     * file.
     *
     * @return true True on success.
     *
     * @warning If the destination file already exists, it will be overwritten.
     * @note File#moveUploaded() is open_basedir aware.<br>
     * However, restrictions are placed only on the path as to allow moving of uploaded files in which from may
     * conflict with such restrictions.<br>
     * File#moveUploaded() ensures the safety of this operation by allowing only those files uploaded through PHP
     * to be moved.
     */
    public static function moveUploaded (string $from, string $to):true {

        return move_uploaded_file($from, $to)
            ?: throw new MoveUploadedFileError;

    }

    /**
     * ### Reads the entire file into a string
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path of the file to read.
     * </p>
     * @param int $offset [optional] <p>
     * The offset where the reading starts on the original stream.<br>
     * Negative offsets count from the end of the stream.<br>
     * Seeking ($offset) is not supported with remote files.<br>
     * Attempting to seek on non-local files may work with small offsets, but this is unpredictable because it works
     * on the buffered stream.
     * </p>
     * @param null|non-negative-int $length [optional] <p>
     * Maximum length of data read. The default is to read until the end of the file is reached.<br>
     * Note that this parameter is applied to the stream processed by the filters.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetContentError If we can't get content from a path.
     *
     * @return string The read data.
     *
     * @note If you're opening a URI with special characters, such as spaces, you need to encode the URI with
     * urlencode().
     */
    public static function getContent (string $path, int $offset = 0, ?int $length = null):string {

        return ($content = file_get_contents($path, false, null, $offset, $length)) !== false
            ? $content : throw new GetContentError;

    }

    /**
     * ### Reads the entire file into an array
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to the file.
     * </p>
     * @param bool $skip_empty_lines [optional] <p>
     * Skip empty lines.
     * </p>
     * @param bool $ignore_new_lines [optional] <p>
     * Omit a newline at the end of each array element.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetContentError If we can't get content from a path.
     *
     * @return list<string> The file in an array.<br>
     * Each element of the array corresponds to a line in the file, with the newline still attached.
     *
     * @warning When using SSL, Microsoft IIS will violate the protocol by closing the connection without sending a
     * close_notify indicator.<br>
     * PHP will report this as "SSL: Fatal Protocol Error" when you reach the end of the data.<br>
     * To work around this, the value of error_reporting should be lowered to a level that doesn't include warnings.<br>
     * PHP can detect buggy IIS server software when you open the stream using the https:// wrapper and will suppress
     * the warning.<br>
     * When using fsockopen() to create a ssl:// socket, the developer is responsible for detecting and suppressing
     * this warning.
     * @note Each line in the resulting array will include the line ending, unless $ignore_new_lines is used.
     * @tip If PHP doesn't properly recognize the line endings when reading files either on or created by a
     * Macintosh computer enabling the auto_detect_line_endings runtime configuration option may help resolve the
     * problem.
     * @tip A URL can be used as a $path.
     */
    public static function getContentArray (string $path, bool $skip_empty_lines = false, bool $ignore_new_lines = false):array {

        return ($content = file($path, match (true) {
            $skip_empty_lines && $ignore_new_lines => FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES,
            $skip_empty_lines => FILE_SKIP_EMPTY_LINES,
            $ignore_new_lines => FILE_IGNORE_NEW_LINES,
            default => 0
        })) !== false
            ? $content : throw new GetContentError;

    }

    /**
     * ### Write data to a file
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\File::isFile() To tell whether the $file is a regular file.
     *
     * @param non-empty-string $path <p>
     * Path to the file where to write the data.
     * </p>
     * @param string[]|string $data <p>
     * The data to write.
     * </p>
     * @param bool $append [optional] <p>
     * Append the data to the file instead of overwriting it.
     * </p>
     * @param bool $lock [optional] <p>
     * Acquire an exclusive lock on the file while proceeding to the writing.
     * </p>
     * @param bool $create_file [optional] <p>
     * Is true, the method will create a new file if one doesn't exist.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\PathDoesntExistError If $path is not file.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\PutContentError If the $create_file option is off or
     * couldn't put content on a path.
     *
     * @return non-negative-int The number of bytes that were written to the file false otherwise.
     */
    public static function putContent (string $path, array|string $data, bool $append = false, bool $lock = true, bool $create_file = false):int {

        if (!$create_file && !self::isFile($path)) throw new PathDoesntExistError;

        return file_put_contents($path, $data, match (true) {
            $append && $lock => FILE_APPEND | LOCK_EX,
            $append => FILE_APPEND,
            $lock => LOCK_EX,
            default => 0
        }) ?: throw new PutContentError;

    }

    /**
     * ### Gets total size of a filesystem or disk partition
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to folder ot disk partition.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\DiskSpaceError If we couldn't get disk space for a
     * path.
     *
     * @return float Returns the total number of bytes as a float.
     *
     * @note Given a filename instead of a folder, the behavior of the function is unspecified and may differ
     * between operating systems and PHP versions.
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     */
    public static function totalSpace (string $path):float {

        return ($space = disk_total_space($path)) !== false
            ? $space : throw new DiskSpaceError;

    }

    /**
     * ### Gets free space of a filesystem or disk partition
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to folder ot disk partition.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\FileSystem\DiskSpaceError If we couldn't get disk space for a
     * path.
     *
     * @return float Returns the total free space of bytes as a float.
     *
     * @note Given a filename instead of a folder, the behavior of the function is unspecified and may differ
     * between operating systems and PHP versions.
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     */
    public static function freeSpace (string $path):float {

        return ($space = disk_free_space($path)) !== false
            ? $space : throw new DiskSpaceError;

    }

    /**
     * ### Clears file status cache
     *
     * When you use FileSystem#statistics() or any of the other functions listed in the affected functions list (below),
     * PHP caches the information those functions return to provide faster performance.<br>
     * However, in certain cases, you may want to clear the cached information.<br>
     * For instance, if the same file is being checked multiple times within a single script, and that file is in
     * danger of being removed or changed during that script's operation, you may elect to clear the status cache.<br>
     * In these cases, you can use the FileSystem#clearCache() function to clear the information that PHP caches
     * about a file.<br>
     * You should also note that PHP doesn't cache information about non-existent files.<br>
     * So, if you call FileSystem#exist() on a file which doesn't exist, it will return false until you create
     * the file.<br>
     * If you create the file, it will return true even if you then delete the file.<br>
     * However, File#delete() clears the cache automatically.
     * @since 1.0.0
     *
     * @param bool $clear_realpath_cache [optional] <p>
     * Whether to also clear the realpath cache.
     * </p>
     * @param string $path [optional] <p>
     * Clear the realpath cache for a specific filename only.<br>
     * Only used if $clear_realpath_cache is true.
     * </p>
     *
     * @return void
     *
     * @phpstan-impure
     *
     * @note This function caches information about specific filenames, so you only need to call clearCache() if you
     * are performing multiple operations on the same filename and require the information about that particular file
     * to not be cached.
     */
    public static function clearCache (bool $clear_realpath_cache = false, string $path = ''):void {

        clearstatcache($clear_realpath_cache, $path);

    }

}