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
use FireHub\Core\Throwable\Error\LowLevel\ClsObj\ {
    ClassDoesntExistError, FailedToCreateAliasError
};

use function class_alias;
use function class_exists;
use function class_parents;
use function class_implements;
use function class_uses;
use function enum_exists;
use function get_class_methods;
use function get_class_vars;
use function get_mangled_object_vars;
use function get_object_vars;
use function get_parent_class;
use function method_exists;
use function property_exists;
use function interface_exists;
use function is_a;
use function is_subclass_of;
use function spl_object_hash;
use function spl_object_id;
use function trait_exists;

/**
 * ### Low-level Class & Object Utilities
 *
 * Provides a set of low-level static helper methods to inspect and manipulate classes and objects in a type-safe,
 * FireHub low-level style.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class ClsObj extends LowLevel {

    /**
     * ### Checks if a class name exists
     *
     * This method checks whether the given class has been defined.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Cls::isEnum() To check if $name is enum.
     *
     * @param class-string $name <p>
     * The class name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if not already loaded.
     * </p>
     *
     * @return bool True if class exist, false otherwise.
     */
    public static function isClass (string $name, bool $autoload = true):bool {

        return class_exists($name, $autoload);

    }

    /**
     * ### Checks if interface name exists
     *
     * Checks if the given interface has been defined.
     * @since 1.0.0
     *
     * @param interface-string $name <p>
     * The interface name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if not already loaded.
     * </p>
     *
     * @return bool True if the interface exists, false otherwise.
     */
    public static function isInterface (string $name, bool $autoload = true):bool {

        return interface_exists($name, $autoload);

    }

    /**
     * ### Checks if an enum name exists
     *
     * This method checks whether the given enum has been defined.
     * @since 1.0.0
     *
     * @param enum-string $name <p>
     * The enum name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if not already loaded.
     * </p>
     *
     * @return bool True if enum exists, false otherwise.
     */
    public static function isEnum (string $name, bool $autoload = true):bool {

        return enum_exists($name, $autoload);

    }

    /**
     * ### Checks if trait name exist
     * @since 1.0.0
     *
     * @param trait-string $name <p>
     * The trait name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if not already loaded.
     * </p>
     *
     * @return bool True if the trait exists, false otherwise.
     */
    public static function isTrait (string $name, bool $autoload = true):bool {

        return trait_exists($name, $autoload);

    }

    /**
     * ### Checks if the class method exists
     * @since 1.0.0
     *
     * @param class-string|object $object_or_class <p>
     * An object instance or a class name.
     * </p>
     * @param non-empty-string $method <p>
     * The method name.
     * </p>
     *
     * @return bool True if the method given by method has been defined for the given object_or_class, false otherwise.
     *
     * @note Using this function will use any registered autoloader if the class is not already known.
     */
    public static function methodExist (string|object $object_or_class, string $method):bool {

        return method_exists($object_or_class, $method);

    }

    /**
     * ### Checks if the object or class has a property
     *
     * This method checks if the given property exists in the specified class.
     * @since 1.0.0
     *
     * @param class-string|object $object_or_class <p>
     * The class name or an object of the class to test for.
     * </p>
     * @param non-empty-string $property <p>
     * The name of the property.
     * </p>
     *
     * @return bool True if the property exists, false if it doesn't exist.
     *
     * @note As opposed with isset(), ClsObj#propertyExist() returns true even if the property has the value null.
     * @note This method can't detect properties that are magically accessible using the __get magic method.
     * @note Using this function will use any registered autoloaders if the class is not already known.
     */
    public static function propertyExist (string|object $object_or_class, string $property):bool {

        return property_exists($object_or_class, $property);

    }

    /**
     * ### Checks whether the object or class is of a given type or subtype
     *
     * Checks if the given $object_or_class is of this object type or has this object type as one of its supertypes.
     * @since 1.0.0
     *
     * @template TObject of object
     *
     * @param class-string|object $object_or_class <p>
     * A class name or an object instance.
     * </p>
     * @param class-string<TObject> $class <p>
     * The class or interface name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @phpstan-assert-if-true TObject $object_or_class
     *
     * @return bool True if the object is of this object type or has this object type as one of its supertypes,
     * false otherwise.
     */
    public static function ofClass (string|object $object_or_class, string $class, bool $autoload = true):bool {

        return is_a($object_or_class, $class, $autoload);

    }

    /**
     * ### Checks if a class has this class as one of its parents or implements it
     *
     * Checks if the given object_or_class has the class $class as one of its parents or implements it.
     * @since 1.0.0
     *
     * @template TObject of object
     *
     * @param class-string|object $object_or_class <p>
     * The tested class.<br>
     * No error is generated if the class doesn't exist.
     * </p>
     * @param class-string<TObject> $class <p>
     * The class or interface name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @phpstan-assert-if-true TObject $object_or_class
     *
     * @return bool True if the object is of this object or lass type or has this object type as one of its supertypes,
     * false otherwise.
     */
    public static function subClassOf (string|object $object_or_class, string $class, bool $autoload = true):bool {

        return is_subclass_of($object_or_class, $class, $autoload);

    }

    /**
     * ### Creates an alias for a class
     *
     * Creates an alias named alias based on the user-defined class.<br>
     * The aliased class is exactly the same as the original class.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\ClsObj::isClass() To check if the original class exists before creating
     * an alias.
     *
     * @param class-string $class <p>
     * The original class.
     * </p>
     * @param class-string $alias <p>
     * The alias name for the class.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if the original class is not found.
     * </p>
     *
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\FailedToCreateAliasError If failed to create alias for
     * the class.
     *
     * @return true True on success.
     *
     * @note Class names are case-insensitive in PHP, and this is reflected in this function.<br>
     * Aliases created by ClsObj#alias() are declared in lowercase.<br>
     * This means that for a class MyClass, the ClsObj#alias('MyClass', 'My_Class_Alias') call will declare a new
     * class alias named my_class_alias.
     */
    public static function alias (string $class, string $alias, bool $autoload = true):true {

        return self::isClass($class) && class_alias($class, $alias, $autoload)
            ?: throw new FailedToCreateAliasError;

    }

    /**
     * ### Gets the accessible non-static properties and their values
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\ClsObj::isClass() To check if the class exists before getting its
     * properties.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * The class name or an object instance.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError If the class doesn't exist.
     *
     * @return array<string, mixed> Returns an associative array of declared properties visible from the current
     * scope, with their values.
     *
     * @note The result depends on the current scope.
     * @note Using this function will use any registered autoloader if the class is not already known.
     */
    public static function properties (string|object $object_or_class):array {

        /** @var array<string, mixed> */
        return match (true) {
            DataIs::object($object_or_class) => get_object_vars($object_or_class),
            default => self::isClass($object_or_class)
                ? get_class_vars($object_or_class)
                : throw new ClassDoesntExistError
        };

    }

    /**
     * ### Gets the mangled object properties
     *
     * Returns an array whose elements are the object's properties.<br>
     * The keys are the member variable names, with a few notable exceptions: private variables have the class name
     * prepended to the variable name, and protected variables have a * prepended to the variable name.<br>
     * These prepended values have NUL bytes on either side.<br>
     * Uninitialized typed properties are silently discarded.
     * @since 1.0.0
     *
     * @param object $object <p>
     * An object instance.
     * </p>
     *
     * @return array<string, mixed> An array containing all properties, regardless of visibility, of an object.
     */
    public static function mangledProperties (object $object):array {

        /** @var array<string, mixed> */
        return get_mangled_object_vars($object);

    }

    /**
     * ### Gets the class or object methods names
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\ClsObj::isClass() To check if the class exists before getting its methods.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * The class name or an object instance.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError If the class doesn't exist.
     *
     * @return array<string> Returns an array of method names defined for the class, or false if the class doesn't
     * exist.
     *
     * @note The result depends on the current scope.
     */
    public static function methods (string|object $object_or_class):array {

        return self::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? get_class_methods($object_or_class)
            : throw new ClassDoesntExistError;

    }

    /**
     * ### Retrieves the parent class name for an object or class
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\ClsObj::isClass() To check if the class exists before getting its parent.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * The tested object or class name.<br>
     * This parameter is optional if called from the object's method.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError If the class doesn't exist.
     *
     * @return class-string|false The name of the parent class for the class that $object_or_class is an instance
     * or the name, or false if object_or_class doesn't have a parent.
     */
    public static function parentClass (string|object $object_or_class):string|false {

        return self::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? get_parent_class($object_or_class)
            : throw new ClassDoesntExistError;

    }

    /**
     * ### Return the parent classes of the given class
     *
     * This function returns an array with the name of the parent classes for the given object_or_class.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\ClsObj::isClass() To check if the class exists before getting its parents.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * An object (class instance) or a string (class or interface name).
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError If the class doesn't exist.
     *
     * @return array<string, class-string> An array on success.
     */
    public static function parents (object|string $object_or_class, bool $autoload = true):array {

        /** @var array<string, class-string> */
        return self::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? class_parents($object_or_class, $autoload)
            : throw new ClassDoesntExistError;

    }

    /**
     * ### Return the interfaces which are implemented by the given class or interface
     *
     * This function returns an array with the names of the interfaces that the given object_or_class and its parents
     * implement.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\ClsObj::isClass() To check if the class exists before getting its
     * interfaces.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * An object (class instance) or a string (class or interface name).
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError If the class doesn't exist.
     *
     * @return array<string, class-string> An array.
     */
    public static function implements (object|string $object_or_class, bool $autoload = true):array {

        /** @var array<string, class-string> */
        return self::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? class_implements($object_or_class, $autoload)
            : throw new ClassDoesntExistError;

    }

    /**
     * ### Return the traits used by the given class
     *
     * This function returns an array with the names of the traits that the given object_or_class uses.<br>
     * This does, however, not include any traits used by a parent class.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\ClsObj::isClass() To check if the class exists before getting its traits.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * An object (class instance) or a string (class or interface name).
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError If the class doesn't exist.
     *
     * @return array<string, class-string> An array.
     */
    public static function uses (object|string $object_or_class, bool $autoload = true):array {

        /** @var array<string, class-string> */
        return self::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? class_uses($object_or_class, $autoload)
            : throw new ClassDoesntExistError;

    }

    /**
     * ### Return the integer object handle for a given object
     *
     * This function returns a unique identifier for the object.<br>
     * The object id is unique for the lifetime of the object.<br>
     * Once the object is destroyed, its id may be reused for other objects.
     * This behavior is similar to Obj#hash().
     * @since 1.0.0
     *
     * @param object $object <p>
     * Any object.
     * </p>
     *
     * @return positive-int An integer identifier that is unique for each currently existing object and is always
     * the same for each object.
     *
     * @note When an object is destroyed, its id may be reused for other objects.
     */
    public static function id (object $object):int {

        /** @var positive-int */
        return spl_object_id($object);

    }

    /**
     * ### Return hash id for a given object
     *
     * This function returns a unique identifier for the object.<br>
     * This id can be used as a hash key for storing objects or for identifying an object, as long as the object is
     * not destroyed.<br>
     * Once the object is destroyed, its hash may be reused for other objects.
     * @since 1.0.0
     *
     * @param object $object <p>
     * Any object.
     * </p>
     *
     * @return non-empty-string A string that is unique for each currently existing object and is always the same
     * for each object.
     *
     * @note When an object is destroyed, its hash may be reused for other objects.
     * @note Object hashes should be compared for identity with === and !==, because the returned hash could be a
     * numeric string.<br>
     * For example, 0000000000000e600000000000000000.
     */
    public static function hash (object $object):string {

        /** @var non-empty-string */
        return spl_object_hash($object);

    }

}