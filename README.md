# Hydrant Template Engine

*Hydrant* is a template class for CodeIgniter 2 PHP framework based on [http://www.h2o-template.org](H2O Template Engine) a cross-platform component available for both PHP and Ruby/Rails, inspired by Django Templates. This makes your templates more portable and increase the value of your know-how.

## Installation

### Library version

* Clone this repo or download it as ZIP archive.
* Copy content of the `libraries` folder in your `application/libraries` folder
* Copy `config/hydrant.php` in your `application/config` folder

You're done, load Hydrant as usual:

<code>
  $this->load->library('hydrant');
</code>

**BEWARE**: Hydrant will need working CI2 Cache driver. It will load it automagically but you could want to make sure your caching is properly configured in your application config files.

### Spark version

* Install spark as usual with something like

  <code>
  $ php tools/spark install hydrant
  </code>

Done! Load Hydrant in your code with:

<code>
  $this->load->spark('1.0.0/hydrant');
</code>

## Usage

You could use Hydrant in two ways. One is via the library itself, the other is using a custom CI2 loader that allows you to stick to good old <code>$this->load->view()</code> syntax.

### Using Hydrant directly

Easypeasy, you could use `$this->hydrant->render()` method that works pretty much like `$this->load->view()`, taking three parameters:

1. Full template file name (String)
1. Data to pass to template (Associative array)
1. Wether to show output or return it in a variable (Boolean, Optional): passing TRUE will return rendered template instead of showing it

**Example:**

      $data['title']   = 'My nice title';
      $data['content'] = 'Goodbye World!'; // never had a bad day? :P
    
      $this->hydrant->render('bye.tpl.html', $data);
      $useless_var = $this->hydrant->render('useless_bye.tpl.html', $data, TRUE);

### Using Hydrant with custom CI2 Loader

To enable this feature you have to put a custom version of CI Loader in place.
You could find the custom loader in `extras` directory in your spark path.

**BEWARE: Your brain must be involved in subsequent steps, don't blame me if you screw something up copying and pasting as hell!**

In `extras` directory you'll find two Loader files:

* **MY\_Loader.php.Library**
* **MY\_Loader.php.Sparks**

If you are using Hydrant as a library, odds are good that no custom loader file is in place in your `application/core` directory. In that case you could copy and paste safely `MY_Loader.php.Library` file in mentioned directory renaming it just `MY_Loader.php`.

If you're using Hydrant Spark, it means that a `MY_Loader.php` file is already there (at least in CodeIgniter 2.0.3 and below, 2.1 *should* get rid of it integrating Sparks natively, but as I'm writing this, 2.1 has not yet released). If so, you have two choices:

* **Unsafe**: you could try your luck overwriting current `MY_Loader.php` with `MY_Loader.php.Sparks` that is basically an already merged version of Sparks loader (done by hand by me based on the last version available of Sparks Loader, at the time of writing).
* **Safe**: open `MY_Loader.php.Library`, and manually copy/paste the `view()` method into your current custom loader, so that it doesn't conflict with the code already in place.

In both cases (Spark or Library), you could happen to have a custom loader already in place, so please **turn your brain on** and _Search your feelings!_ (cit.)

Once you're done with the above, you'll be happy to use `$this->load->view()` for both Hydrant templates and standard CI views.

#### How?

With a simple naming convention. Save your Hydrant templates as .htpl files and use

      $this->load->view('mytemplate.htpl', $my_data);
      
The loader will spot the `htpl` extension and use the right renderer engine (one exclude the other entirely, so don't mix PHP and H2O code in the same view!).

#### What if I have `.htpl.php` views files already in production?

First of all, let me tell you that there should be something wrong with you! :D
Then, open an issue and I'll address it in next releases. Pull requests are even more appreciated!

## How to write templates

So far, you could refer to [https://github.com/speedmax/h2o-php/wiki](H2O Documentation) to learn about writing templates. Since Hydrant is basically a wrapper for H2O, I'll strive to maintain it up-to-date and copying and pasting docs is not worth the effort.

## Extra boons (not yet documented)

* Using Hydrant with Rope: TBD
* H2O and CI2 i18n integration: TBD