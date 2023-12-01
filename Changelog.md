# Xtend Changelog

## Unreleased
#### 2023-XX-YY

- Fixed the shared registry bug by removing the `BaseRegistry` class. The traits need to be used instead.
- Added the `Registry::ids()`, `Registry::reset()` and `Registry::choices()` methods
- Added the `Registerable` interface (optional)

## 1.0.0
#### 2023-11-30

- Initial release
- Added the `Registry` interface and a boilerplate implementation (either via traits or extending the base class)
