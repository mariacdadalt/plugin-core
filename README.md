# Plugin Core

This project creates a MU Plugin that acts like a framework for new plugins. The objetive of this plugin is to allow for more code reuse, using the idea of the DRY principle, without abandoning code readability and allowing for a more modular approach.

**Main advantages**
- Makes the base code for a project easier to update, since it is separated from the features of the project.
- Allows an easy way to share code between projects, with little to no changes.
- A cleaner features plugin, where the base code that allows for modern development is hidden in the plugin-core.
- Spin up a new plugin with modern development tools takes little time.
- Cleaner PR's, with only main files needing changes.

## Concepts and Tools

### Composer and Satis Server

This project relies heavily on composer’s power to modulate code. One downside of composer has always been how fast the composer.json file can get overwhelming when you have a list of VCS repositories to use. To resolve this problem, we use a Private Composer Server, called [Satis](https://github.com/composer/satis). With the satis server, we will have one more repository of the type composer and each component will add only a line to the “require” property. With this, we achieve a cleaner composer file, without losing the ability to override a component, if needed.

### WordPress Hooks and Filters

This structure relies heavily on the idea of hooks and filters introduced by wordpress. With them, we have the ability to keep a code unchanged and customize it at the same time. This is what we are trying to achieve. While writing for this structure, there are a couple of questions we should ask:
- This change I am making, will it be beneficial to other projects?
- If so, where is the best place for this functionality to be customized or overridden?
- If this affects only my project, is there an existing hook or filter I can use?
- If not, where should I put a hook or filter for the thing I am trying to achieve?

### Dependency Injection and Autoloading

This project uses [PHP DI](https://php-di.org/doc/) as the container for dependency injection. The DI container with the autoload features of composer, makes a powerful combo. With both of them, we are able to use Definers as a way to define which class should be loaded according to our needs. This will also help with Unit Testing and cleaner code.

### Separation of Concerns and Mustache Engine

This project uses [Mustache](https://github.com/bobthecow/mustache.php) as the renderer provider. This allows us to separate presentation code from logic code, allowing us to have an HTML that will be rendered in our PHP files.

### Feature Folder Structure and Webpack

This project uses [Webpack](https://webpack.js.org/) as a compiler of Javascript and SCSS. With it is possible to achieve a Feature Folder Structure, as we can keep all files related to a feature into a single service folder.

### Naming Conventions

Most of the names used in this projects have some functionality agregated to it. This way, we can achieve a modular approach with a plug-and-play feeling.

- `Abstractions` Folder
	- This folder will have all abstract classes and interfaces. The classes in this folder are not supposed to be implementations, so putting them inside one single folder allows us to remember that these particular classes won’t get instantiated. Abstract classes also are used by more than one service (as they should) so maintaining them in one single folder allows us to lessen the risk of creating two classes that are mainly the same thing. Always refer to the Abstract classes in the Core plugin before creating an abstract class in the project plugin. And, before creating this abstract class in the project plugin, allow yourself to consider if this class won’t be useful in other projects. Maybe this class belongs in the Core plugin and not in the Project plugin.
- `Services` Folder
	- Inside this folder is where most of the code will live. Each folder inside will be named after a service, aiming to a SoC (Separation of Concern) approach. There is a couple of naming conventions inside the service folder.
	- `Views` Folder
		- Inside this folder, all files related to the Views can be found. The `Index.html` is a reserved name for the default render of the service. You can create other html files here, to render, passing the name of the file to the controller.
		- If you're using the webpack for compiling code, then all Javascript created inside this folder will be enqueued on the page automatically. To enqueue the styles, use a `import './Index.scss'` inside the js file. That way the webpack will know to compile it.
	- `*Controller` Files
		- Controller files are very powerful, but they have a few constraints. As a naming convention, you always need to name your controller after your Service Name + Controller. So, for example, if you have a ˜UserDetail˜ service (where the name of the folder is UserDetail), your controller would necesserelly need to be called ˜UserDetailController˜. Using this name convention, this controller will be able to render any html files inside the views folder.
	- `*Subscriber` Files
		-
	- `*Definer` Files
		-
	- `*Runner` Files
		-
	- `*CPT` Files

## Usage

This project is a framework to make your job easier when coding a new plugin. If you want to create a plugin based in this project, the first thing you need to do is create your plugin from [this template](https://github.com/mariacdadalt/plugin-template/generate). This project works better with the [WP Started](https://wecodemore.github.io/wpstarter/) package, that allows us to require this recent created plugin in our `composer.json` file. That way, this project is mostly ready to use. Take a look at the [Plugin Template](https://github.com/mariacdadalt/plugin-template)'s README to some instructions on how to use the features.

If you don't want to use the VCS repository for this plugin, you can add the following repo to your `composer.json`.

```
	{
		"type": "composer",
		"url": "https://mariacdadalt.github.io/composer-satis/"
	},
```
