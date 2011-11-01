<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Cache Time To Live
|--------------------------------------------------------------------------
|
| How many second a result should be cached?
| Defaults to 1 hour
|
*/
$config['cache_ttl'] = 60 * 60; // 60 minutes

/*
|--------------------------------------------------------------------------
| Automatically escape variables on parsing
|--------------------------------------------------------------------------
|
| Wether to escape all vars before rendering them into views
| This is TRUE by default and you should turn this off only if you
| know what you're doing.
|
*/
$config['autoescape'] = TRUE;

/*
|--------------------------------------------------------------------------
| Template elements delimiters
|--------------------------------------------------------------------------
|
| H2O library allows you to change markers for tags/blocks, variables and
| comments.
| Following values are default ones and assure your templates are compatible
| with Django and H2O for Ruby.
| Since 99% of both H2O and Twig (http://twig.sensiolabs.org) syntax is inspired
| by Django templates, these delimiters allow your templates to be parsed by
| Twig with none-to-zero effort.
|
| Modify them only if you know what you're doing.
|
*/
$config['env_block_start']    = '{%';
$config['env_block_end']      = '%}';
$config['env_variable_start'] = '{{';
$config['env_variable_end']   = '}}';
$config['env_comment_start']  = '{*';
$config['env_comment_end']    = '*}';

/*
|--------------------------------------------------------------------------
| Trim tags output
|--------------------------------------------------------------------------
|
| Wether to trim output from H2O tags (not HTML tags).
| Defaults to TRUE.
|
*/
$config['env_trim_tags'] = TRUE;