# DFWP 
WordPress theme starter ([Changelog](https://github.com/posykrat/dfwp/blob/master/changelog.md))

## Requirements
- Yarn (https://yarnpkg.com/fr/)
- Composer (https://getcomposer.org/)
- Advanced Custom Fileds Pro (https://www.advancedcustomfields.com)

## Installation
```
cd wp-content/themes/
git clone https://github.com/posykrat/dfwp.git foldername
cd foldername
git remote set-url origin https://github.com/USERNAME/REPOSITORY.git
cd build
composer install
yarn install
```

## Configuration

### Build and Browsersync
- `build/gulpfile.js`

### PostCSS
- Loader: `src/loader/loader.css`
- Default layout conf : `src/layout/default/default.css`

### JavasScript
- Build entrie point : `src/loader/main.js` 

### Styleguide
- Config `styleguide/config.md`


### Apache VHOST 
```
#projectname.local
<VirtualHost *:80>
	DocumentRoot "h:/www/projectname"
	ServerName projectname.local
	ServerAlias www.projectname.local
	<Directory "h:/www/projectname/">
		Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require local
	</Directory>
</VirtualHost>
```

## Gulp tasks
- `gulp` : defaut task (`styles-project` `styles-styleguide` `scripts` `svg-sprite` `styleguide` `browser-sync`) + watch  
- `wc3css` : validation W3C CSS avec reporting warnings + errors

Tips : `--silent` pour une sortie console moins encombrée 

## ACF
Les champs sont sauvegarder sous forme de fichiers `json` dans le dossier `functions/admin/acf-json`, cela permet de les ré-importer au besoin. Il est recommandé d'exporter les champs en PHP et de copier le code généré dans le fichier `functions/admin/settings.php` lorsque les champs sont stabilisés.

## Styleguide
En administration, créer une page nommée styleguide et l'associé au template styleguide. Le styleguide est accessible via www.exemple.com/styleguide. Le fichier styleguide.css est chargé uniquement pour cette page. Variables disponibles dans les fichiers .md de composants : 

```
{svg-path}
```