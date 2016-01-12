# QQ: A null coalescing Twig operator for CraftCMS

by Michael Rog  
[http://topshelfcraft.com](http://topshelfcraft.com)



### TL;DR.

This plugin lets you replace expressions like...
```
{{ thing1 is defined and thing1 is not null ? thing1 : thing2 }}
```
...with something nicer, like...
```
{{ thing1 ?? thing 2 }}
``` 


   
* * *



### What is a null coalescing operator?

The Null Coalescing Operator (sometimes called the Logical Defined-Or Operator) is nifty operator that basically says: _"Give me the first operand in this expression, from left to right, that is both defined and not null. And, if all of the operands are undefined or null, just return null._"



### Why do I care?


##### 1. An easier way to manage fallbacks for null/undefined values

You have probably come across a case where you want to use some variable in your Twig template, but only if it is actually defined. If not, you want to fall back to a default value.

For these situations, Twig's `?:` (the [_elvis operator_](https://en.wikipedia.org/wiki/Elvis_operator)) and `|default` [filter](http://twig.sensiolabs.org/doc/filters/default.html) may be useful. However, both of these become unmanageably verbose when there are more than one or two possible variables in play. For example...
```
thing1|default(thing2|default(thing3|default(thing4|default('Oy vey.'))))
```
or worse...
```
(thing1 is defined and thing1 is not null ? thing1 : (thing2 is defined and thing2 is not null ? thing2 : (thing3 is defined and thing3 is not null ? thing3 : ('This is ridiculous.') ) ) )
```

Our code becomes _much_ more concise and readable if we use the `??` operator, like so:
```
thing1 ?? thing2 ?? thing3 ?? thing4 ?? 'Nice.'
```


##### 2. Prevents Twig errors if some of the values are undefined

If you have Craft's `devMode` or Twig's `strict_variables_check` enabled, Twig will throw an error if it encounters a variable that is undefined, or if you try to access a property of a variable that is null.

By definition, the Null Coalescing Operator expects that some of its operands may be undefined or null, so it doesn't throw an error if in fact this is the case.


##### 3. Prevent superfluous accessor overhead / side effects

The elvis operator (`?:`) is actually parsed as a full ternary expression (i.e. `thing 1 ? thing 1 : thing2`).

This means that the first operand (_thing1_, above) is accessed twice. If accessing this variable triggers a query or other computation, or has side-effects, using it in a ternary expression might be unideal.

The Null Coalescing Operator is right-associative and only accesses each variable once.



### How is this implemented?

PHP includes a null-coalescing operator natively as of [version 7](http://php.net/manual/en/language.operators.comparison.php), and this plugin implements a shim for earlier versions of PHP.



### How do I use it?

Download the plugin, copy the `qq` directory to your Craft plugins directory, and install the plugin in the _Settings > Plugins_ area of your CraftCMS control panel.

Once you have installed the plugin, you'll be able to use the **`??`** and **`qq`** operators in your Craft templates.

### Wait, huh? Why `??` _and_ `qq`?

_The two variants are functionally identical._

I included both in this plugin because Twig may eventually include a native `??` operator in its core, and it should be up to you whether to fall back to that native operator automatically, or to keep using the plugin's bundled operator until you explicitly decide to swap it out for the newer, native version.



### I found a bug.

No you didn't!


### Yes I did.  :-/

Oh. Well, okay. Please open a GitHub Issue, submit a PR, or just email me to let me know.