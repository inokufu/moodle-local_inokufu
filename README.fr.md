Inokufu Search - Local Services Plugin pour la plateforme Moodle™
=================================

Inokufu Search - Local Services Plugin pour la plateforme Moodle™ 
fait partie de l'ensemble des plugins permettant d'intégrer Inokufu Search dans votre plateforme Moodle™.
Cet ensemble inclut également :
- [Inokufu Search - Repository plugin pour la plateforme Moodle™](https://github.com/inokufu/moodle-repository_inokufu), 
- [Inokufu Search - TinyMCE plugin pour la plateforme Moodle™](https://github.com/inokufu/moodle-tinymce_inokufu). 
- [Inokufu Search - Atto Plugin pour la plateforme Moodle™](https://github.com/inokufu/moodle-atto_inokufu). 

Ce plugin permet aux utilisateurs d'intéragir avec notre [API Learning Object](https://gateway.inokufu.com/) depuis d'autres plugins de leur plateforme Moodle™, en centralisant l'appel aux points d'entrée API.
Ce document vous guidera à travers l'installation et l'utilisation du plugin.

## Installation

### Installation à partir d'un ZIP
1. Téléchargez le fichier zip du plugin à partir de ce dépôt GitHub.
2. Connectez-vous à votre site Moodle en tant qu'administrateur.
3. Accédez à `Administration du site > Plugins > Installer des plugins`.
4. Téléversez le fichier zip que vous avez téléchargé à partir de ce dépôt GitHub et suivez les instructions à l'écran.
5. Remplissez et confirmez les formulaires pour terminer l'installation du plugin.

### Installation à partir des sources
1. Établissez une connexion SSH à votre instance Moodle.
2. Clonez les fichiers source à partir de ce dépôt GitHub directement dans vos fichiers source Moodle.
3. Renommez le dossier cloné en `inokufu`.
4. Déplacez le dossier `inokufu` dans le dossier `local` de votre installation Moodle. Assurez-vous que le dossier du plugin est nommé `inokufu`.
5. Ouvrez le dossier dans un terminal.
6. Installez les dépendances Composer (vous devrez [installer Composer](https://getcomposer.org/download/) si vous ne le possédez pas déjà).
```sh
composer install
```
7. Connectez-vous à votre site Moodle en tant qu'administrateur.
8. Accédez à `Administration du site > Notifications` pour finaliser l'installation du plugin.

## Configuration
1. Après une installation réussie, vous devriez voir apparaître un menu de configuration (où vous pouvez notamment saisir votre clé API). Vous pouvez toutefois retrouver ce menu ici : `Administration du site > Plugins > Plugins locaux > Inokufu Services`.
2. Enregistrez les modifications et commencez à utiliser notre plugin.

**Note :** Une Clé API est requise afin de pouvoir utiliser ce plugin. Pour obtenir une Clé API, veuillez vous référer à la section [Inokufu APIs Gateway](https://gateway.inokufu.com/) ou contacter le [Support Inokufu](https://support.inokufu.com/).

## Utilisation
**Note:** Ce cas d'utilisation n'est nécessaire que pour la création de nouveau plugins, ceux de notre ensemble `Inokufu Search pour Moodle` sont déjà préconfigurés comme suit.

1. Pour appeler ce plugin depuis un autre, vous devrez importer la bibliothèque Moodle `externallib`.
```php
require_once ($CFG->libdir . '/externallib.php'); 
```
2. Ensuite, il suffit d'appeler la fonction voulue de notre service avec la syntaxe suivante :
```php
$result = external_api::call_external_function(
    'nom_de_ma_fonction', 
    ['params' => $params],  // Nous attendons $params comme un tableau associatif
    null                    // Pour utiliser le contexte actuel
);
```
Vous pouvez obtenir la liste de nos fonctions depuis `Administration du site > Serveur > Services web > Services externes`, puis en sélectionnant `Fonctions` sur la ligne `local_inokufu`.

3. Le format de données reçues varie selon la fonction appelée, mais Moodle fournit au moins quelques champs généraux afin de s'assurer que l'appel a été réussi :
```php
if (isset($result['error']) && !$result['error'] && isset($result['data'])) {
    // Pas d'erreurs, données dans la clé 'data'
    return $result['data'];
} else if (isset($result['exception'])) {
    // Erreur, détails dans la clé 'exception'
    throw new Exception(json_encode($result['exception']));
} else {
    // Erreur non supportée
    throw new Exception('Erreur non supportée' . json_encode($result));
}
```
4. Vous pouvez dès lors accéder aux données de notre API depuis un autre plugin.


## Résolution des problèmes
Si vous rencontrez des problèmes avec le plugin, veuillez vérifier les points suivants :
1. Assurez-vous que votre site Moodle répond aux exigences minimales pour le plugin.
2. Vérifiez que votre Clé API est correctement remplie et valide.
3. Vérifiez que le nom d'hôte utilisé dans la page de configuration est valide (en cas de doute, laissez le champ vide)
4. Consultez le journal Moodle (`Administration du site > Rapports > Journaux`) pour voir s'il y a des messages d'erreur liés au plugin.
5. Si aucune de ces étapes ne vous a aidé, n'hésitez pas à contacter notre [Support Inokufu](https://support.inokufu.com/).

## Support
Pour obtenir une assistance supplémentaire ou signaler un problème, veuillez visiter le dépôt GitHub du plugin et ouvrir une `issue`. Veillez à inclure tous les détails pertinents, tels que la version de votre Moodle, la version du plugin et une description détaillée du problème.