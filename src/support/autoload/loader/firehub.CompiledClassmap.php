<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\Autoload\Loader;

use FireHub\Core\Support\Autoload\Loader;

/**
 * ### High-performance compiled classmap autoloader
 *
 * CompiledClassmap is a final autoloader implementation that replaces traditional array-based or PSR-4 class
 * resolution with a switch-based dispatch.<br>
 * Each fully qualified class name maps directly to a required statement, eliminating runtime array lookups and
 * filesystem checks. This approach is optimized for PHAR distribution and production environments, providing
 * significantly faster class loading—up to 2–5× faster than standard classmaps, and up to 10× faster when combined
 * with a single-file compiled core. It is intended to be used after a minimal Preloader and before a Resolver fallback,
 * ensuring all core classes are loaded efficiently while maintaining full namespace support.
 * @since 1.0.0
 *
 * @internal
 */
final readonly class CompiledClassmap implements Loader {

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function __invoke (string $class):void {

        switch ($class) {

            case \Collection2::class:
                require __DIR__.'/../../../index.php';
                return;

            case \Collection3::class:
                require __DIR__.'/../../../index.php';
                return;

            case \FireHub\Core\Domain\Autoload\Handle::class:
                require __DIR__.'/../../../domain/autoload/firehub.Handle.php';
                return;

            case \FireHub\Core\FireHub::class:
                require __DIR__.'/../../../firehub.FireHub.php';
                return;

            case \FireHub\Core\Shared\Contracts\ArrayConvertable::class:
                require __DIR__.'/../../../shared/contracts/firehub.ArrayConvertable.php';
                return;

            case \FireHub\Core\Shared\Contracts\Arrayable::class:
                require __DIR__.'/../../../shared/contracts/firehub.Arrayable.php';
                return;

            case \FireHub\Core\Shared\Contracts\Countable::class:
                require __DIR__.'/../../../shared/contracts/firehub.Countable.php';
                return;

            case \FireHub\Core\Shared\Contracts\Iterator::class:
                require __DIR__.'/../../../shared/contracts/firehub.Iterator.php';
                return;

            case \FireHub\Core\Shared\Contracts\IteratorAggregate::class:
                require __DIR__.'/../../../shared/contracts/firehub.IteratorAggregate.php';
                return;

            case \FireHub\Core\Shared\Contracts\JsonSerializable::class:
                require __DIR__.'/../../../shared/contracts/firehub.JsonSerializable.php';
                return;

            case \FireHub\Core\Shared\Contracts\JsonSerializableConvertable::class:
                require __DIR__.'/../../../shared/contracts/firehub.JsonSerializableConvertable.php';
                return;

            case \FireHub\Core\Shared\Contracts\Magic\Serializable::class:
                require __DIR__.'/../../../shared/contracts/magic/firehub.Serializable.php';
                return;

            case \FireHub\Core\Shared\Contracts\Magic\SerializableConvertable::class:
                require __DIR__.'/../../../shared/contracts/magic/firehub.SerializableConvertable.php';
                return;

            case \FireHub\Core\Shared\Contracts\Magic\Stringable::class:
                require __DIR__.'/../../../shared/contracts/magic/firehub.Stringable.php';
                return;

            case \FireHub\Core\Shared\Contracts\Throwable::class:
                require __DIR__.'/../../../shared/contracts/firehub.Throwable.php';
                return;

            case \FireHub\Core\Shared\Contracts\Traversable::class:
                require __DIR__.'/../../../shared/contracts/firehub.Traversable.php';
                return;

            case \FireHub\Core\Shared\Enums\Comparison::class:
                require __DIR__.'/../../../shared/enums/firehub.Comparison.php';
                return;

            case \FireHub\Core\Shared\Enums\ControlFlow\Signal::class:
                require __DIR__.'/../../../shared/enums/controlflow/firehub.Signal.php';
                return;

            case \FireHub\Core\Shared\Enums\Data\Category::class:
                require __DIR__.'/../../../shared/enums/data/firehub.Category.php';
                return;

            case \FireHub\Core\Shared\Enums\Data\ResourceType::class:
                require __DIR__.'/../../../shared/enums/data/firehub.ResourceType.php';
                return;

            case \FireHub\Core\Shared\Enums\Data\Type::class:
                require __DIR__.'/../../../shared/enums/data/firehub.Type.php';
                return;

            case \FireHub\Core\Shared\Enums\DateTime\Format\Predefined::class:
                require __DIR__.'/../../../shared/enums/datetime/format/firehub.Predefined.php';
                return;

            case \FireHub\Core\Shared\Enums\DateTime\Zone::class:
                require __DIR__.'/../../../shared/enums/datetime/firehub.Zone.php';
                return;

            case \FireHub\Core\Shared\Enums\FileSystem\Permission::class:
                require __DIR__.'/../../../shared/enums/filesystem/firehub.Permission.php';
                return;

            case \FireHub\Core\Shared\Enums\Json\Flag::class:
                require __DIR__.'/../../../shared/enums/json/firehub.Flag.php';
                return;

            case \FireHub\Core\Shared\Enums\Json\Flag\Decode::class:
                require __DIR__.'/../../../shared/enums/json/flag/firehub.Decode.php';
                return;

            case \FireHub\Core\Shared\Enums\Json\Flag\Encode::class:
                require __DIR__.'/../../../shared/enums/json/flag/firehub.Encode.php';
                return;

            case \FireHub\Core\Shared\Enums\Json\Flag\Error::class:
                require __DIR__.'/../../../shared/enums/json/flag/firehub.Error.php';
                return;

            case \FireHub\Core\Shared\Enums\Json\Flag\Validate::class:
                require __DIR__.'/../../../shared/enums/json/flag/firehub.Validate.php';
                return;

            case \FireHub\Core\Shared\Enums\Number\LogBase::class:
                require __DIR__.'/../../../shared/enums/number/firehub.LogBase.php';
                return;

            case \FireHub\Core\Shared\Enums\Number\Round::class:
                require __DIR__.'/../../../shared/enums/number/firehub.Round.php';
                return;

            case \FireHub\Core\Shared\Enums\Order::class:
                require __DIR__.'/../../../shared/enums/firehub.Order.php';
                return;

            case \FireHub\Core\Shared\Enums\Side::class:
                require __DIR__.'/../../../shared/enums/firehub.Side.php';
                return;

            case \FireHub\Core\Shared\Enums\String\CaseFolding::class:
                require __DIR__.'/../../../shared/enums/string/firehub.CaseFolding.php';
                return;

            case \FireHub\Core\Shared\Enums\String\Compare::class:
                require __DIR__.'/../../../shared/enums/string/firehub.Compare.php';
                return;

            case \FireHub\Core\Shared\Enums\String\Count\CharacterMode::class:
                require __DIR__.'/../../../shared/enums/string/count/firehub.CharacterMode.php';
                return;

            case \FireHub\Core\Shared\Enums\String\Count\WordFormat::class:
                require __DIR__.'/../../../shared/enums/string/count/firehub.WordFormat.php';
                return;

            case \FireHub\Core\Shared\Enums\String\Encoding::class:
                require __DIR__.'/../../../shared/enums/string/firehub.Encoding.php';
                return;

            case \FireHub\Core\Shared\Enums\String\Sort::class:
                require __DIR__.'/../../../shared/enums/string/firehub.Sort.php';
                return;

            case \FireHub\Core\Shared\Enums\SystemRuntime\IniAccessLevel::class:
                require __DIR__.'/../../../shared/enums/systemruntime/firehub.IniAccessLevel.php';
                return;

            case \FireHub\Core\Shared\Enums\SystemRuntime\PhpExtension::class:
                require __DIR__.'/../../../shared/enums/systemruntime/firehub.PhpExtension.php';
                return;

            case \FireHub\Core\Shared\ValueObject::class:
                require __DIR__.'/../../../shared/firehub.ValueObject.php';
                return;

            case \FireHub\Core\Support\Autoload::class:
                require __DIR__.'/../../../support/firehub.Autoload.php';
                return;

            case \FireHub\Core\Support\Autoload\Loader::class:
                require __DIR__.'/../../../support/autoload/firehub.Loader.php';
                return;

            case \FireHub\Core\Support\Autoload\Loader\Classmap::class:
                require __DIR__.'/../../../support/autoload/loader/firehub.Classmap.php';
                return;

            case \FireHub\Core\Support\Autoload\Loader\CompiledClassmap::class:
                require __DIR__.'/../../../support/autoload/loader/firehub.CompiledClassmap.php';
                return;

            case \FireHub\Core\Support\Autoload\Loader\Resolver::class:
                require __DIR__.'/../../../support/autoload/loader/firehub.Resolver.php';
                return;

            case \FireHub\Core\Support\Bootstrap\Bootloader::class:
                require __DIR__.'/../../../support/bootstrap/firehub.Bootloader.php';
                return;

            case \FireHub\Core\Support\Bootstrap\Bootloader\RegisterAutoloaders::class:
                require __DIR__.'/../../../support/bootstrap/bootloader/firehub.RegisterAutoloaders.php';
                return;

            case \FireHub\Core\Support\Bootstrap\Bootloader\RegisterConstants::class:
                require __DIR__.'/../../../support/bootstrap/bootloader/firehub.RegisterConstants.php';
                return;

            case \FireHub\Core\Support\Bootstrap\Bootloader\RegisterHelpers::class:
                require __DIR__.'/../../../support/bootstrap/bootloader/firehub.RegisterHelpers.php';
                return;

            case \FireHub\Core\Support\Bootstrap\FireHubConfigurator::class:
                require __DIR__.'/../../../support/bootstrap/firehub.FireHubConfigurator.php';
                return;

            case \FireHub\Core\Support\Contracts\DataStructure::class:
                require __DIR__.'/../../../support/contracts/firehub.DataStructure.php';
                return;

            case \FireHub\Core\Support\DataStructure\Abstract\Collection::class:
                require __DIR__.'/../../../support/datastructure/abstract/firehub.Collection.php';
                return;

            case \FireHub\Core\Support\DataStructure\Collection::class:
                require __DIR__.'/../../../support/datastructure/firehub.Collection.php';
                return;

            case \FireHub\Core\Support\DataStructure\Contracts\Collection::class:
                require __DIR__.'/../../../support/datastructure/contracts/firehub.Collection.php';
                return;

            case \FireHub\Core\Support\DataStructure\Traits\Convertable::class:
                require __DIR__.'/../../../support/datastructure/traits/firehub.Convertable.php';
                return;

            case \FireHub\Core\Support\DataStructure\Traits\Enumerable::class:
                require __DIR__.'/../../../support/datastructure/traits/firehub.Enumerable.php';
                return;

            case \FireHub\Core\Support\DataStructure\Traits\Shared::class:
                require __DIR__.'/../../../support/datastructure/traits/firehub.Shared.php';
                return;

            case \FireHub\Core\Support\LowLevel::class:
                require __DIR__.'/../../../support/firehub.LowLevel.php';
                return;

            case \FireHub\Core\Support\LowLevel\Arr::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Arr.php';
                return;

            case \FireHub\Core\Support\LowLevel\CharMB::class:
                require __DIR__.'/../../../support/lowlevel/firehub.CharMB.php';
                return;

            case \FireHub\Core\Support\LowLevel\CharSB::class:
                require __DIR__.'/../../../support/lowlevel/firehub.CharSB.php';
                return;

            case \FireHub\Core\Support\LowLevel\ClsObj::class:
                require __DIR__.'/../../../support/lowlevel/firehub.ClsObj.php';
                return;

            case \FireHub\Core\Support\LowLevel\Constant::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Constant.php';
                return;

            case \FireHub\Core\Support\LowLevel\Data::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Data.php';
                return;

            case \FireHub\Core\Support\LowLevel\DataIs::class:
                require __DIR__.'/../../../support/lowlevel/firehub.DataIs.php';
                return;

            case \FireHub\Core\Support\LowLevel\DateAndTime::class:
                require __DIR__.'/../../../support/lowlevel/firehub.DateAndTime.php';
                return;

            case \FireHub\Core\Support\LowLevel\Declared::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Declared.php';
                return;

            case \FireHub\Core\Support\LowLevel\FileSystem::class:
                require __DIR__.'/../../../support/lowlevel/firehub.FileSystem.php';
                return;

            case \FireHub\Core\Support\LowLevel\Func::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Func.php';
                return;

            case \FireHub\Core\Support\LowLevel\Iterator::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Iterator.php';
                return;

            case \FireHub\Core\Support\LowLevel\Json::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Json.php';
                return;

            case \FireHub\Core\Support\LowLevel\Math::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Math.php';
                return;

            case \FireHub\Core\Support\LowLevel\Random::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Random.php';
                return;

            case \FireHub\Core\Support\LowLevel\Regex::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Regex.php';
                return;

            case \FireHub\Core\Support\LowLevel\RegexMB::class:
                require __DIR__.'/../../../support/lowlevel/firehub.RegexMB.php';
                return;

            case \FireHub\Core\Support\LowLevel\Resources::class:
                require __DIR__.'/../../../support/lowlevel/firehub.Resources.php';
                return;

            case \FireHub\Core\Support\LowLevel\SplAutoload::class:
                require __DIR__.'/../../../support/lowlevel/firehub.SplAutoload.php';
                return;

            case \FireHub\Core\Support\LowLevel\StrMB::class:
                require __DIR__.'/../../../support/lowlevel/firehub.StrMB.php';
                return;

            case \FireHub\Core\Support\LowLevel\StrSB::class:
                require __DIR__.'/../../../support/lowlevel/firehub.StrSB.php';
                return;

            case \FireHub\Core\Support\LowLevel\SystemRuntime::class:
                require __DIR__.'/../../../support/lowlevel/firehub.SystemRuntime.php';
                return;

            case \FireHub\Core\Testing\Base::class:
                require __DIR__.'/../../../testing/firehub.Base.php';
                return;

            case \FireHub\Core\Throwable\Builder::class:
                require __DIR__.'/../../../throwable/firehub.Builder.php';
                return;

            case \FireHub\Core\Throwable\Error::class:
                require __DIR__.'/../../../throwable/firehub.Error.php';
                return;

            case \FireHub\Core\Throwable\ErrorBuilder::class:
                require __DIR__.'/../../../throwable/firehub.ErrorBuilder.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Arr\ChunkLengthTooSmallError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/arr/firehub.ChunkLengthTooSmallError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Arr\FailedToSortMultiArrayError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/arr/firehub.FailedToSortMultiArrayError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Arr\KeysAndValuesDiffNumberOfElemsError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/arr/firehub.KeysAndValuesDiffNumberOfElemsError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Arr\OutOfRangeError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/arr/firehub.OutOfRangeError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/autoload/firehub.RegisterAutoloadError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Arr\SizeInconsistentError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/arr/firehub.SizeInconsistentError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Arr\UnregisterAutoloaderError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/autoload/firehub.UnregisterAutoloaderError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/clsobj/firehub.ClassDoesntExistError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\ClsObj\FailedToCreateAliasError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/clsobj/firehub.FailedToCreateAliasError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Constant\AlreadyExistError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/constant/firehub.AlreadyExistError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Constant\FailedToDefineError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/constant/firehub.FailedToDefineError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Constant\NotDefinedError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/constant/firehub.NotDefinedError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Data\ArrayToStringConversionError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/data/firehub.ArrayToStringConversionError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Data\CannotSerializeError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/data/firehub.CannotSerializeError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Data\FailedToSetTypeError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/data/firehub.FailedToSetTypeError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Data\SetAsResourceError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/data/firehub.SetAsResourceError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Data\TypeUnknownError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/data/firehub.TypeUnknownError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Data\UnserializeFailedError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/data/firehub.UnserializeFailedError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\DateTime\FailedToFormatTimestampAsIntError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/datetime/firehub.FailedToFormatTimestampAsIntError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\DateTime\FailedToGetZoneError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/datetime/firehub.FailedToGetZoneError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\DateTime\FailedToSetZoneError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/datetime/firehub.FailedToSetZoneError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\DateTime\FormatTimestampError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/datetime/firehub.FormatTimestampError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\DateTime\ParseFromFormatError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/datetime/firehub.ParseFromFormatError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\DateTime\StringToTimestampError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/datetime/firehub.StringToTimestampError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CannotListError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.CannotListError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\ChangeSymlinkGroupError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.ChangeSymlinkGroupError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\ChangeSymlinkOwnerError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.ChangeSymlinkOwnerError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CopyPathError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.CopyPathError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CreateFolderError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.CreateFolderError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CreateLinkError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.CreateLinkError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\CreateSymlinkError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.CreateSymlinkError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\DeletePathError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.DeletePathError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\DiskSpaceError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.DiskSpaceError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetAbsolutePathError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetAbsolutePathError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetContentError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetContentError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetGroupError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetGroupError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetInodeError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetInodeError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetLastAccessedError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetLastAccessedError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetLastChangedError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetLastChangedError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetLastModifiedError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetLastModifiedError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetOwnerError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetOwnerError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetPathSizeError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetPathSizeError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetPermissionsError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetPermissionsError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetStatisticsError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetStatisticsError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\GetSymlinkError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.GetSymlinkError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\MoveUploadedFileError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.MoveUploadedFileError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\ParentLevelTooSmallError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.ParentLevelTooSmallError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\PathDoesntExistError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.PathDoesntExistError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\PutContentError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.PutContentError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\ReadFileError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.ReadFileError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\RenameError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.RenameError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SearchError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.SearchError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SetGroupError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.SetGroupError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SetLastAccessAndModifyError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.SetLastAccessAndModifyError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SetOwnerError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.SetOwnerError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\FileSystem\SetPermissionsError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/filesystem/firehub.SetPermissionsError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Func\RegisterTickFailedError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/func/firehub.RegisterTickFailedError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\InvalidValueObjectError::class:
                require __DIR__.'/../../../throwable/error/valueobject/firehub.InvalidValueObjectError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Json\DecodeError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/json/firehub.DecodeError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Json\EncodeError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/json/firehub.EncodeError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Number\ArithmeticError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/number/firehub.ArithmeticError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Number\DivideByZeroError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/number/firehub.DivideByZeroError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Random\MaxLessThanMinError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/random/firehub.MaxLessThanMinError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Random\NumberGreaterThanMaxError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/random/firehub.NumberGreaterThanMaxError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Random\NumberLessThanMinError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/random/firehub.NumberLessThanMinError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Random\SecureNumberError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/random/firehub.SecureNumberError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\Regex\InvalidPatternError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/regex/firehub.InvalidPatternError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\String\ChunkLengthLessThanOneError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/string/firehub.ChunkLengthLessThanOneError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\String\CodepointOutsideValidRangeError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/string/firehub.CodepointOutsideValidRangeError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\String\ComparePartError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/string/firehub.ComparePartError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\String\EmptyPadError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/string/firehub.EmptyPadError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\String\EmptySeparatorError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/string/firehub.EmptySeparatorError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/string/firehub.InvalidEncodingError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\FailedToGetProcessIDError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/systemruntime/firehub.FailedToGetProcessIDError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\FailedToGetServerAPIError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/systemruntime/firehub.FailedToGetServerAPIError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\FailedToSetConfigurationOptionError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/systemruntime/firehub.FailedToSetConfigurationOptionError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidConfigurationOptionError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/systemruntime/firehub.InvalidConfigurationOptionError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidConfigurationQuantityError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/systemruntime/firehub.InvalidConfigurationQuantityError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidExtensionError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/systemruntime/firehub.InvalidExtensionError.php';
                return;

            case \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\SleepTimeInvalidError::class:
                require __DIR__.'/../../../throwable/error/lowlevel/systemruntime/firehub.SleepTimeInvalidError.php';
                return;

            case \FireHub\Core\Throwable\Exception::class:
                require __DIR__.'/../../../throwable/firehub.Exception.php';
                return;

            case \FireHub\Core\Throwable\ExceptionBuilder::class:
                require __DIR__.'/../../../throwable/firehub.ExceptionBuilder.php';
                return;

            case \FireHub\Core\Throwable\Exception\DataStructure\WrongReturnTypeException::class:
                require __DIR__.'/../../../throwable/exception/datastructure/firehub.WrongReturnTypeException.php';
                return;

            case \FireHub\Core\Throwable\Exception\Domain\Autoload\ImplementationException::class:
                require __DIR__.'/../../../throwable/exception/domain/autoload/firehub.ImplementationException.php';
                return;

            case \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidFolderException::class:
                require __DIR__.'/../../../throwable/exception/domain/autoload/firehub.InvalidFolderException.php';
                return;

            case \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidHandleException::class:
                require __DIR__.'/../../../throwable/exception/domain/autoload/firehub.InvalidHandleException.php';
                return;

            case \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidNamespaceException::class:
                require __DIR__.'/../../../throwable/exception/domain/autoload/firehub.InvalidNamespaceException.php';
                return;

            case \FireHub\Core\Throwable\Exception\Support\Bootstrap\FailedToLoadBootloaderException::class:
                require __DIR__.'/../../../throwable/exception/support/bootstrap/firehub.FailedToLoadBootloaderException.php';
                return;

            case \FireHub\Core\Throwable\Exception\Support\Bootstrap\NotBootloaderException::class:
                require __DIR__.'/../../../throwable/exception/support/bootstrap/firehub.NotBootloaderException.php';
                return;

            case \FireHub\Core\Throwable\Throwable::class:
                require __DIR__.'/../../../throwable/firehub.Throwable.php';
                return;

            case \FireHub\Core\Throwable\ValueObject\Code::class:
                require __DIR__.'/../../../throwable/valueobject/firehub.Code.php';
                return;

        }

    }

}