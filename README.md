# Flyn Xenforo Integration for WordPress

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
![Build Status - PHP](https://github.com/Flynsarmy/wp-flyn-xenforo-integration-plugin/workflows/CI%20-%20PHP/badge.svg)

This plugin integrates Xenforo into WordPress.

## Installation

* `git clone` to */wp-content/plugins/flyn-xenforo*
* `composer install --no-dev`
* Add `define('FLYNXENFORO_API_KEY', 'your-api-key');` to *wp-config.php*
* Add a minutely cron for the URL *https://yoursite.com/wp-admin/admin-ajax.php?action=flynxenforo-recache*

## Usage

* The shortcode `[xenforo categories]` displays all categories
* The shortcode `[xenforo category=29]` displays a given category