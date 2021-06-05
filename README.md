# System - Jiji
Jiji is a System Plugin leveraging the Joomla! 4 webservices by adding custom actions to core Joomla! console without "hacks" using DI Container and other Joomla! 4 advanced capabilities.

------------------------

English:

------------------------

## WHY ?
I started Jiji back in december 2020 because at that time I wanted some kind of proof of concept, a toy project to try out the new Joomla! 4 console which is based on Symfony Console. If you already know Symfony Console you will be at home with Joomla! 4 Console.

## WHAT ?
"Jiji" name comes from what I thought might be a "cute girl" name based on a short nickname version of our beloved "Joomla!" which is a tramemark of Open Source Matters by the way.

## HOW ?
Jiji is a System Plugin which "adds" or "registers" new commands to the default joomla console cli script JPATH_ROOT/cli/joomla.php
I could create my own console script for that named JPATH_ROOT/cli/jiji.php but I thought it might be better to have only one entrypoint for joomla cli which make it easier to remember. You will tell me if I am wrong. Willing to hear your feedback on that.
The "Jiji" code is in a Library placed in the src directory inside the plugin.
it is namespaced as AE\Library\Jiji  the vendor name AE are just my initials and the Library is also called Jiji just like the Plugin but with CamelCase.
The Behavior directory holds all the Php Traits used by the Plugin. Traits are there since Php 5.4. Basically, they are common behaviours used in unrelated Php Classes. In other words, when you find yourself copy/pasting again and again a functionnality from one Class to another, it might be a good candidate for a Trait.
The heart of this plugin is in the AE\Library\Jiji\Console namespace. Is the corresponding directory you will find my first Console Command named HelloSuperJoomlerCommand.php which just says "Hello Super Joomler". But another directory more interesting is Article directory where are all Article related Commands. 
 - GET all articles (Browse)
 - GET one article by id (Read)
 - PATCH one article by id (Edit)
 - POST one article by id (Add)
 - DELETE one article by id (Delete)

 In order to DELETE you must first do a PATCH with at minimum the category id , the title and the state as -2 of the article you want to DELETE. 
 Example JSON payload: '{"catid":64, "title":"My edited title", "state":-2}'
"Jiji" can use a JSON file or JSON string as payload for your requests containing a body.

## INSTRUCTIONS:
1 - The extension zip is in the build/ directory of [this repository](https://github.com/alexandreelise/plg_system_jiji/blob/master/build/plg_system_jiji_202103071735.zip)

2 - Install the Jiji plugin as any other Joomla! 4 extension.

3 - Follow these instructions

JPATH_ROOT : the root directory of your joomla 4 website. Change this with the revelant directory absolute path

J4X_BASE_PATH : Your Joomla! 4 Base Url (eg: https://example.com)

J4X_API_TOKEN : Your Joomla! 4 API Token

You can use it non-interactive by adding the -n

### Execute the basic Command Hello Super Joomler
```

php JPATH_ROOT/cli/joomla.php jiji:hello

```
### Execute the Browse Article Command

```

php JPATH_ROOT/cli/joomla.php -n --base-path=J4X_BASE_PATH --api-token=J4X_API_TOKEN article:browse

```
### Execute the Read Article Command (eg: id=1)

```

php JPATH_ROOT/cli/joomla.php -n --base-path=J4X_BASE_PATH --api-token=J4X_API_TOKEN article:read --id=1

```

### Execute the Add Article Command

using a JSON string as payload

```

php JPATH_ROOT/cli/joomla.php -n --base-path=J4X_BASE_PATH --api-token=J4X_API_TOKEN article:add --item-data='{"alias": "my-article","articletext": "My text","catid": 64,"language": "*","metadesc": "","metakey": "","title": "Here's an article"}'

```

or more conveniently using a JSON file as payload

```

php JPATH_ROOT/cli/joomla.php -n --base-path=J4X_BASE_PATH --api-token=J4X_API_TOKEN article:add --item-data='path/to/add-article.json'

```

### Execute the Edit Article Command (eg: id=1)

using a JSON string as payload

```

php JPATH_ROOT/cli/joomla.php -n --base-path=J4X_BASE_PATH --api-token=J4X_API_TOKEN article:edit --id=1 --item-data='{"catid": 64,"title": "Here's an another article"}'

```

or more conveniently using a JSON file as payload

```

php JPATH_ROOT/cli/joomla.php -n --base-path=J4X_BASE_PATH --api-token=J4X_API_TOKEN article:edit --id=1 --item-data='path/to/edit-article.json'

```


### Execute the Delete Article Command (eg: id=1)

This must be done in two steps due to [this new way to do it](https://github.com/joomla/joomla-cms/pull/31581)

1 -  Execute the Edit Article Command on the article you want to delete by change it's state to -2 (Trash)

2 - Execute the Delete Article Command on the article you want to delete.

#### Step 1 for Deleting Article

using a JSON string as payload

```

php JPATH_ROOT/cli/joomla.php -n --base-path=J4X_BASE_PATH --api-token=J4X_API_TOKEN article:edit --id=1 --item-data='{"catid": 64,"title": "Here's an another article", "state": -2}'

```

or more conveniently using a JSON file as payload

```

php JPATH_ROOT/cli/joomla.php -n --base-path=J4X_BASE_PATH --api-token=J4X_API_TOKEN article:edit --id=1  --item-data='path/to/delete-step-1-article.json'

```

#### Step 2 Deleting Article

```

php JPATH_ROOT/cli/joomla.php -n --base-path=J4X_BASE_PATH --api-token=J4X_API_TOKEN article:delete --id=1

```



## CONTRIBUTORS
Contributors are welcomed to jump in and help improve this project. Any constructive feedback is welcomed.

--------------------------------------------
## INFOS

> English: [Click here to get in touch](https://github.com/mralexandrelise/mralexandrelise/blob/master/community.md "Get in touch")

> Français: [Cliquez ici pour me contacter](https://github.com/mralexandrelise/mralexandrelise/blob/master/community.md "Me contacter")
