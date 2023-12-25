<p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://user-images.githubusercontent.com/5760249/132945127-a7d3a4bb-1ffc-4658-8096-c9cfc2f5c3dd.png" width="400"></a>
</p>

# Humam Menu Management System


The project is built with the following components:

- Vue 3 / Pinia / VueRouter
- Vue 3 Composition API
- Vite 3
- Laravel Framework
- Laravel Sanctum
- Laravel Fortify
- Tailwind
- ForkAwesome
- Media Library (by Spatie)
- Bouncer (by JosephSilber)


### ➡️ Main Features

* Authentication system
* One Menu for each user created automaticaly
* Update menu info
* Add as needed of categories and support 4 levels of sub categories
* Delete Category or Item
* add discount on menu, category and item level with accumulation effect


## ⚡️ How to install

Installation is simple. Just like your ordinary Laravel app.

1. `git clone`
2. `cd to project root dir`
3. `composer install`
4. `cp .env.example .env`
5. `php artisan key:generate`   
5. `Run php artisan migrate`   
6. `Run php artisan db:seed`   
7. `php artisan storage:link`   
8. `npm install`
9. `npm run watch` (or if production `npm run build`)

## ⚡️ How it works

### ➡️ Theming

The project supports theming, you can set a global color for the application theme, it can be done in `tailwind.config.js`.

```js
module.exports = {
    // ...
    theme: {
        extend: {
            colors: {
                theme: colors.teal,
                danger: colors.red
            }
        }
    },
    //...
};
```

### ➡️ Authentication

The project ships with complete authentication boilerplate including:
- Login
- Register
- Forget Password
- Reset Password

### ➡️ Authorization

The project is configured to use [Bouncer](https://github.com/JosephSilber/bouncer) package for managing authorization across your routes. Authorization is important security subject, so please consult bouncer's package documentation.


### ➡️ Structure

The front-end code is located in `resources/js`. The code is organized in different directories to make things more readable.

| Directory    | Description                           |
|--------------|---------------------------------------|
| views        | The home of views                     |
| + pages      | The home of the pages                 |
| + icons      | The home of the icons                 |
| + layouts    | The home of the global layouts        |
| + components | The home of the reusable components   |
| helpers      | The home of the helper utilites       |
| plugins      | The home of the plugins configuration |
| router       | The home of the router configuration  |
| services     | The home of the HTTP services         |
| stores       | The home of the Pinia stores          |
| stub         | The home of the static constants      |

### ➡️ Components

The project ships with the most useful components that are required for one application (no bullshit), including:

| Name      | Description                                                | Parameters                                                                                                                                                     | Events                                   | Location               |
|-----------|------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------|------------------------|
| Page      | The main page wrapper                                      | title, breadcrumbs (array), actions (array of actions on top), is-loading                                                                                      | n/a                                      | views/layouts          |
| Panel     | Panel wrapper for displaying panels into the pages         | title, is-loading, body-padding                                                                                                                                | n/a                                      | views/components       |
| Modal     | Modal wrapper for creating modals                          | is-showing, is-loading, show-close                                                                                                                             | @close                                   | views/components       |
| Form      | Form wrapper                                               | title, is-loading                                                                                                                                              | n/a                                      | views/components       |
| Table     | A custom table with sorting and pagination support         | headers (array), records (array), actions (array of row actions), sorting (object of keys with true/false), pagination: (object of Laravel pagination data)    | @page-changed, @action, $sort            | views/components       |
| Alert     | Alert component that pulls alrts from AlertStore           | n/a                                                                                                                                                            | n/a                                      | views/components       |
| Badge     | Component that displays highlighted text with background   | theme (success, info, warning, danger, error)                                                                                                                  | n/a                                      | views/components       |
| TextInput | Custom text field with type={text,..., textarea} support   | name, label, v-model, type (text,...,textarea, etc), show-label, required, disabled, placeholder                                                               | default                                  | views/components/input |
| FileInput | File input with custom button and multiple choices support | name, label, v-model, show-label, required, disabled, placeholder, multiple, accept                                                                            | default + @click, @error, @input, @clear | views/components/input |
| Dropdown  | Dropdown field with server side support                    | name, label, v-model, show-label, required, disabled, placeholder, multiple, server (endpoint), server-per-page (items per page), server-search-min-characters | default                                  | views/components/input |
| Button    | Button/Router link component                               | label, icon, theme (success, info, warning, danger, error), disabled, to (:to is router url, when specified the button is rendered as router-link)             | default                                  | views/components/input |
| Spinner   | Spinner icon used mostly for loading                       | text, text-new-line (whether to break the text under the spinner)                                                                                              | n/a                                      | views/components/icons |
| Icon      | Icon wrapper, currently uses fork awesome                  | name (the icon name without the fa- part)                                                                                                                      | n/a                                      | views/components/icons |
| Avatar    | Default Avatar icon                                        | n/a                                                                                                                                                            | n/a                                      | views/components/icons |

Note: Please always look in the components, this table does not show everything.



### ➡️ CORS

Please make sure you have APP_URL, SANCTUM_STATEFUL_DOMAINS and SESSION_DOMAIN set correctly in [.env] file as follows:

#### Normal domain

```
APP_URL=http://mywebsite.com

SANCTUM_STATEFUL_DOMAINS=mywebsite.com
SESSION_DOMAIN=mywebsite.com
```

#### Localhost with port

```
APP_URL=http://localhost:8000

SANCTUM_STATEFUL_DOMAINS=localhost:8000
SESSION_DOMAIN=localhost
```
## Authors

- [@hyb90](https://github.com/hyb90)

