# PJAX plugin for Craft CMS 3.x

Automagically return the headers and container that PJAX expects

![Screenshot](resources/img/icon.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require superbig/craft-pjax

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for PJAX.

## PJAX Overview

[pjax](https://github.com/defunkt/jquery-pjax) is a jQuery plugin that uses ajax and pushState to deliver a fast browsing experience with real permalinks, page titles, and a working back button.

pjax works by fetching HTML from your server via ajax and replacing the content of a container element on your page with the loaded HTML. It then updates the current URL in the browser using pushState.

Brought to you by [Superbig](https://superbig.co)
