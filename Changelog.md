# Xtend Changelog

## 1.2.0
#### 2024-07-15

- Added the `HasRegistry::getIdOf()` method (it's not part of the `Registry` interface yet;will be added in v2.0)

## 1.1.0
#### 2023-12-01

- Fixed the shared registry bug by removing the `BaseRegistry` class. The traits need to be used instead.
- Added the `Registry::ids()`, `Registry::reset()` and `Registry::choices()` methods
- Added the `Registerable` interface (optional)

## 1.0.0
#### 2023-11-30

- Initial release
- Added the `Registry` interface and a boilerplate implementation (either via traits or extending the base class)
