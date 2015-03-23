MAGENTO COURSE (OFFICIAL)
=========================

---

Section 2
---------

---

### Lesson 1. Overview

Magento is **OOP** oriented.

**Gang of Four** Design pattern je primenjen u Magentu. > Ukratko, to su neki paterni u programiranju koji se ponavljaju.

**GRASP** design pattern > General Responsibility Assignment Software Patterns (or Principles), > Principi: > 1. Controller > 2. Creator > 3. Indirection > 4. Information Expert > 5. High Cohesion > 6. Low Coupling > 7. Polymorphism

---

**MVC** baziran framework. 1. Model 2. View 3. Controller

Pros:* Modular, Flexible, Standard structure, Maintenance, Migration, Reusable model code Cons:* Performance, lot of files, 3 layers not always enough

Magento primanjuje malo drugaciji oblik MVC.* Thin Controllers - To znaci da se logika sistema ne nalazi u ctrl* View - je slozeniji i mnogo bitniji u Magentu, 3 komponente: 1. Layout XML - Konfiguracion fajl + layout  2. Block - Ovde se nalazi sva logika 3. Template (Sam HTML, ono sto se renderuje)* Spominje se termin View Model, mislim da se nesto slicno spominje i u AngularJS

Magento FLOW:* Request iz browsera* System(server) odlucuje koji se poziva *modul* i *config** Odatle se startuje odgovarajuci *ctrl* i *action** *ctrl* pokrece odgovarajuci *layout.xml** *layout* odredjuje koji *block* se pokrece* *block* poziva *model** *model* uzima podatke iz DB

---

### Lesson 2. Event-driven Architecture

EDA ili Event Driven Architecture je stil razvoja aplikacija koji je fokusiran na *asynchronous* PUSH komunikaciju.

> SUSTINA: Omogucava pristup bilo kom procesu iz bilo kog dela aplikacije. Ova razmena se obavlja u real-time. Eventi su glavni mehanizam za prenos info. JS AJAX je jedan od primera ili JQuery events(click, dblclick itd..)

Event-driven programming je paradigma u kojoj je *flow* aplikacije determinisan uz pomoc eventova: npr. user actions, msg from other threads, apps...

Magento specificnosti za EDA: 1. Event-Observer 2. Pipe-and-Filter 3. Intercepting Filters

PUSH pristup:* Sistem u kome se eventovi generisu "This is happening"* Inside > Out

POOLING pristup: (proveriti tacan naziv, ovo je slicnije JS)* "Hey is this happening?"* Outside > In

> EDA OVERVIEW:
>
> Pros:* Laksi razvojni proces* Lakse je poboljsati delove app* Fleksibilnija app
>
> Cons:* Manje logican flow app* App interakcije su teze za kontrolisanje
>
> Dodatno objasnjenje za system expansibility (lakse je poboljsati delove app)
>
> Prime koji je dat je slika sa jednim *event*om na koji se pokrecu nekoliko *observera*(1,2,3..). Sustina je u tome da je moguce dodavati *neogranicen* broj observera i na taj nacin lako prosiriti mogucnosti nekog modula/app.

---

### Lesson 3. Modularity & Module-based Architecture

Modular programming - tehnika koja se zasniva na deljenju neke app u vise odvojenih delova koje zovemo **modules**.

Module **guidelines**:* *opaque* znaci da bude nedostupan(ovo nije najbolja rec) za ostatak sistema* not responcible for managing their dependencies* *plug&play* da su pogodni za takvu upotrebu

Zanimljiva sekcija: Known issues and limitations.

Magento je baziran na **Zend Framework**. On koristi deo Zend frameworka, i odredjene module(klase).

* S obzirom da je baziran na Zend moguce je koristi neke builtin zend classe
  u magentu.

---

### Lesson 4. Magento Dir Structure

root app js lib media skin var .htaccess index.php cron.php

app/
Core of app
> code/ magento code razdvojen u *code pools*
> design/ magento design templates
> locale/ lokalizacija

js/
Sve js lib koje se koriste u Magentu. Sam magento koristi *prototype.js* i *script.aculo.us*. Od verzije 2 default lib ce biti *jquery*.

lib/
Varien i *Mage lib razvijene od strane Magento tima, kao i sve 3rd party PHP lib koje se koriste u magentu kao npr PEAR i Zend

media/
Sve slike, media fajlovi, ili skoro bilo sta sto je uploadovano preko admin.
> catalog/ Mage_Catalogue fajlovi
> customer/ Mage_Customer
> downloadable Mage_Downloadable
> import/

skin/
Svi skinovi za Magento, to je uglavnom front end img i css koji se koriste u themes.
> adminhtml/ admin area
> frontend/ frontend
> install/ install wizard

var/ Temp fajlovi, cache, locks, session storage ...
> cache/ system & user cache
> session/ php session
> tmp

---

*Module Directory Structure*

[Naziv_Modula] > Block > controllers > etc > Helper > Model > sql

- Nije obavezno da svaki modul ima sve ove komponente.

*Block* Dodatni layer izmedju ctrl i view, u Magentu ovde se smesta logika.

> INICIJALIZACIJA Inicijalizacija se vrsi kroz *factory methode*. (za block, helpers, models) Tu su bitni configuracioni fajlovi jer se tu definisu prefix za klase. Class name postaje file path.
>
> createBlock('catalog/product_view')
>
> Mage_Catalogue_Block_Product_View # ovo se moze pratiti kao file path |- class prefix -|- obj -|

*controller* Mesto za ctrl od nekog modula. Nisu includovani od strane *autoloadera*.

NazivController.php -> primer naziva ctrl

*etc* Configuracioni fajlovi XML. > config.xml - bitan fajl za konfiguraciju modula

*Helper/Model* Veoma slicna konfiguracija i dir struktura.

Helper - pomocna klasa koja se koristi da bi neku funkcionalnost ucinio dostupnim u drugim(vise) modula

Model - Business logic of certain Magento entity.

*sql* DB setup, install/upgrade scripte (EAV, attributes itd..)

---

*CODE POOLS*

Organizacija koda. Nalaze se u app/code/

1 local 2 community 3 core

> INICIJALIZACIJA
>
> 1. request dolazi na index.php
> 2. index.php includuje app/Mage.php
> 3. On sadrzi Mage class (applikacija) i Varien/Autoload.php
> 4. U Mage.php se konfiguruse $path gde se traze sve klase, oni su sortirani po prioritetu 1. local 2. community 3. core 4. lib (ovo omogucava *overwriting*)
> 5. Varian/Autoload.php sadrzi autuload($class) method. On efektivno vrsi autoloading tako sto zamenjuje stringove neke klase u odgovarajuci path To je prica o tome da je class name ujedno i file path: Mage_Catalog_Product_View > ujedno je i path za trazeni obj

---
**app/code/Mage.php** Ovaj fajl sadrzi autoloader.
**lib/Varien/Autoload.php::autoload()** Ovaj fajl vrsi samu konverziju za autoload (Class
names >> se konvertuje u file path)
---

CODE POOLS KORISNICI:
* app/code/core >> Magento team, ovo se skoro nikada modifikuje
* app/code/community >> extensions, 3rd party
* app/code/local >> ovo je nasa app, tu se cuvaju i Mage overrides


PHP INCLUDE PATH ORDER: Local > Community > Core Ovo omogucava overwriting Mage klasa.

NAMESPACE Abstract container or enviroment for holding logical grouping. Ukratko to je prvi folder ispod code pool-a.

Npr: app/code/local/Training/Foo *Training = Namespace Foo = Module*

* Konvencija je da svaka kompanija koristi svoje ime za Namespace, kako bi se izbegli konflikti sa kodom drugih korisnika.

---

LOCATING TEMPLATES

app + design + [AREA_NAME] + [PACKAGE_NAME] + [THEME_NAME] + template + [MODULE_NAME]

# File path je relativan samo u odnosu na template folder (znaci nemora ceo path)

Default templates: app/design/[frontend/adminthml/...]/base/default/template

# Layout XML - Konfiguracija od strane modula.

skin/ - u sustini izgled strane, theme, js, img...

js/ - System wide js files location. u root dir

---

PRIMERI:

page.xml > LAYOUT /app/design/frontend/base/default/page.xml

Product.php > MODEL app/code/core/Mage/Catalog/Model/Product.php

Order collection > app/code/core/Mage/Sales/Model/Mysql4/Order/Collection.php

opcheckout.js > THEME JS skin/frontend/base/default/js/opcheckout.js

Varien data collection db > /lib/Varien/Data/Collection/Db.php

---

### Lesson 5. Configuration XML

Magento configuration is a bunch of XML files that are merged together during app initializzation in one tree. Ucitavaju se po alfabetu (files)

* app/etc - Glavna lokacija za config fajlove
>- config.xml enterprise.xml local.xml (ovo su neki root xml fajlovi)

app/etc/modules/ - lokacija cfg za sve module

Izgled XML:<config> - root node <modules> <Namespace_ModuleName> <active>true</active> - da li je ovaj modul aktiva (u upotrebi) <codePool>core</codePool> - kom codePool pripada <depends> - dependencies <Mage_Adminhtml/> - klasa

---
PRIMER<config> <modules> <Enterprise_Banner> <active>true</active> <codePool>core</codePool> <depends> <Mage_Adminhtml/> <Mage_CatalogRule/> <Mage_SalesRule/> <Enterprise_Cms/> <Enterprise_CustomerSegment/> </depends> </Enterprise_Banner> </modules></config>

= app/code/core/Enterprise/Banner/etc/config.xml (za Banner)

---

*XML*

CONFIGURATION AREAS: global, default, frontend(ili admin), catalog

<config> <modules> Module declarations (names, status, dependencies) </modules>

<global> Definitions that should be shared between all scopes * db settings (host, db name, username password) * connection types (read/write) * db adapter * core module class names </global>

<default> Definitions shared between all store configurations * dir structure * system locale * design and theme configs * system options </default>

<frontend> Definitions only for frontend * routers * translation files * layout XML files * Observers declaration </frontend>

<catalog> Only for Mage_Catalog module * Ovaj deo se odnosi na specifican modul </catalog></config>

---

PRISTUP CONFIGURATION VALUE

STORE - Ovo je prodavnica, jer svaki magento app moze da ih ima vise (npr English,France itd..) Obicno se store odnosi na STORE VIEW. STORE = STORE VIEW


	- $store->getConfig($path);
- Get part of config

	- Mage::getStoreConfig($path [,$store]);
- Part of config(opste)

	- Mage::getStoreConfigFlag($path [,$store]);
- Check store flag

	- Mage::getConfig()->getNode($path [,$scope]):
- Access by absolute path

---

VEZBA - KREIRANJE MODULA

1. app/etc/modules > File name konvencija - Namespace_ModuleName.xml >> First_Module.xml
  * Module declaration file
  * XML uvek sadrzi config kao root node

<?xml version="1.0" encoding="UTF-8"?> <config> <modules> <First_Module> <!-- app/code/<codePool>/First/Module --> <active>true</active> <codePool>local</codePool> </First_Module> </modules> </config>

2. Kreirati Modul dir/file u: app/code/local/First/Module
3. Kreirati config file za modul: .../First/Module/etc/config.xml
<config><default> - store <some> <random> <xpath>Test value.</xpath> </random> </some></default><stores> <french> <some> <random> <xpath>French value.</xpath> </random> </some> </french></stores></config>

DEFAULT FALLBACK ZA NEKU ROUTE: Mage/Cms/controllers/IndexController.php > indexAction() - ROOT PATH

PRISTUP INFORMACIJI IZ XML: echo Mage::getStoreConfig('some/random/xpath') = Test value ili French value - u zavisnosti od toga koji je STORE VIEW aktivan

RETURN VALUE OF getCONFIG is OBJ: var_dump( Mage::getConfig()->getNode('default/some/random/xpath') );

---

### Lesson 6. Functional and Factory Class Groups

Class instantiating other classes = *Factory*

REALIZATION IN MAGENTO > Ovo predstavlja tok za instanciranje raznih objekata (model, helper, block)
* Class MAGE - Mage.php 1. Mage::getModel($modelClass = '', $argument = array());
  1 Class Mage_Core_Model_Config
  2 getModelInstance($modelClass='', $constructArguments=array())
  3 getModelClassName($modelClass) // poziva se unutar getModelInstance
  4 getGroupedClassName($groupType, $classId, $groupRootNode=null) Glavni method, svi vode ka njemu ($groupTYpe se podesava da li je model, helper, block). On uzima podatke iz XML config fajlova.

* Class Mage_Core_Model_Config - Ovde se nalaze bitne info za konfigurisanje

Ovo je neka osnovna kofiguracija za xml: config>global>models/helpers/blocks

METHODS INSTANTIATE Mage::getModel('classgroup/...') getResourceModel(...) helper(...)


---

EXAMPLE: Instantiate

- Lokacija: Mage_Cms_Controller_Index > indexAction
- Instantiate product model and resource model Mage::getModel('catalog/product'); Mage::getResourceModel('catalog/product');
- Create sales helper and tempalte block instance Mage::helper('sales') >> 'sales/data' Helperi imaju mogucnost za malo drugacije pozivanje factory metoda. Ukoliko helperi nemaju / deo, on se po defaultu odnosi na *Data*.

- Mage::app()->getLayout()->createBlock('core/template') (ovo je objasnjeno
  u render delu)


PRIMER F() FLOW ZA MAGE::GETMODEL()
1. Mage.php::getModel() >> getModelInstance()
2. getModelInstance() > Mage_Core_Model_Config >> getModelClassName()
3. getModelClassName() >> getGroupedClassName('model/helper/block', $modelClass)
4. getGroupedClassName() je *glavna* methoda
  * Ona filtrira passovan string i vraca $className
  * tu se vrsi i provera za *REWRITE*

---

### Lesson 7. Class Overrides in Magento

OVERRIDEABLE: Model, Resource Model, Block, Helper

MAGE-CORE-MODEL-CONFIG >> Glavna klasa uz pomoc koje Mage vrsi inspekciju
config-a objekta.

PRIMER ZA MODEL:

XML File:<global> ... <models> <sales> // Naziv modula <rewrite> <quote_address>Training_Sales_Model_Quote_Address</quote_address> // Klasa Quote_Address </rewrite> </sales> </models> ...</global>

Poziv kroz factory method: Mage::getModel('sales/quote_address'); // skace na <rewrite>

> Mage_Sales_Model_Quote_Address - ovo je ponasanje bez override * Mage_Sales_Model = class prefix * Quote_Address = odnosi se na model QuoteAddress.php
>
> Training_Sales_Model_Quote_Address - ovo je SA override

XML tok: > global/models/sales/class ili rewrite (sibilings)/quote_address

Zakljucak: U XML <rewrite> smo overridovali default Mage_Sales_Model_Quote_Address, sa nasim kodom. Training/Sales/Model/QuoteAddress.php

---

PRIMER RESOURCE MODEL:

XML File:<global> // ... <models> // tip <cms_mysql4> // Naziv modula <rewrite> <page>Training_Cms_Model_Mysql4_Cms_Page</page> // Klasa Page </rewrite> </cms_mysql4> </models> ...</global>

Poziv: Mage::getResourceModel('cms/page'); // cms a ne cms_mysql4

XML tok: > global/models/cms/resourceModel = 'cms_mysql4' > to znaci da se resourceModel nalazi nize pod nazivom <cms_mysql4> > > global/models/cms_mysql4/class ili rewrite/page medjutim on se poziva factory method sa originalnim nodom cms/page, a ne cms_mysql4/page

cms_mysql4 BITNO Ovo se drugacije ponasa i valjda je sustina da se kod resourceModela XML poziva 2 puta.

Zakljucak: resourceModel ima dodatni xml <node> koji mora da se pronadje. Na nasem primeru postoji samo: Model: models/cms/resourceModel 'cms_mysql4' Resource model: models/cms_mysql4 - za ovo se pise rewrite

Rewrite se pise za models/cms_mysql4/page iako se kod poziva sa cms/page

UKRATKO NEMOZE DA SE <REWRITE> NODE KOJI PISE U FACTORY, JER TO NIJE PUN NAZIV ZA RESOURCE MODEL.

---

BLOCK PRIMER Je isti kao i za model

HELPER PRIMER isto kao i za model/block. Jedina specificnost je da kad ne postoji dodatni / pretpostavlja se da je class name = DATA. Pa se uglavnom <rewrite><data> Mage::helper('checkout') == Mage::helper('checkout/data')

---

EXERCIZE

> TEST SCRIPT
>
> Moze da se stavi u root dir:
>
> <?php include 'app/Mage.php'; Mage::app();

TARGET: Rewrite Mage_Catalog_Model_Product->getName()

CONFIG: 1. app/etc/modules/First_Module.xml - ovo glavni cfg

1. app/code/local/First/Module/etc/config.xml - ovo editujemo
```
<global>
	<models> - tip
		<catalog> - modul
			<rewrite>
				<product> - klasa First_Module_Model_Product
```

PRODUCT.PHP Ovde se upisuje nova rewritovan method:

First/Module/Model/Product.php

```
class First_Module_Model_Product extends Mage_Catalog_Model_Product {
	public function getName(){
		$name = parent::getName();
		return strtoupper($name); // vraca sve u UPPERCASE
} }
```


---

### Lesson 8. Event Observer


Samo jedan method za pozivanje eventova: Mage::dispatchEvent('catalog_product_collection_load_after', array('collection'=>$this))
(Nalazi se u Mage.php)


OBSERVER INVOCATION:

> dispatchEvent()
* Create events and observer obj
  $event = new Varien_Event($args);
  $event->setName($eventName);
  $observer = new Varien_Event_Observer();

* Assign event to observers
  $observer->setData(array('event'=>$event));

* Call observers method
  $method = $obs['method'];
  $observer->addData($args);
  $object = Mage::getModel($obs['model']);
  $object->$method($observer);


NEKI EVENTOVI SE AUTO DISPATCHUJU. Lista:
* _load_before
* _load_after
* _save_before
* _save_after
* _save_commit_after
* _delete_before
* _delete_after
* _delete_commit_after

KONVENCIJE:
1. Jedna Observer.php klasa po modulu
2. Oni su kolekcija observer methoda
3. Te metode moraju da budu public
4. Uvek imaju (*Varien_Event_Observer $observer*) kao parametar
5. Observers are *allways* Models??

PRIMER.
Modifikacija parametara:
Mage::dispatchEvent('catalog_product_collection_load_after', array('collection'=>$this))

```
.. public function productCollectionLoadBefore(Varien_Event_Observer $observer) { ... $collection = $observer->getData('collection'); // odnosi se na array iz dispatch $collection->addFieldToFilter('entity_id', array('nin'=>$productId)); }

```


CONFIGURATION
```
<frontend>
 ..
	<events>
	  <customer_login> - Event code
			<observers>
				<training> - Modul/ konvencija class group
					<type>model</type> - Model ili singleton ili *disabled*
					<class>training/observer</class> - module/class
					<method>bindCustomerLogin</method> - method koji se poziva
```


CRON JOB
Neka vrsta automatizacije.
```
<crontab>
	<jobs>
		<catalog_product_index_price_reindex_all>
			<schedule><cron_expr>0 2 * * *</cron_expr></schedule>
			<run><model>catalog/product_indexer_price::reindexAll</model></run>
```

---

EXERCISE - OBSERVER

1. app/etc/modules/Foo_Bar.xml

config>modules>Foo_Bar>active=true + codePool=local

1. app/code/local/Foo/Bar

etc/config.xml config>frontend>events>catalog_product_load_afte2. app/code/local/Foo/Bar

etc/config.xml

```
<config>

  <global>
    <models>
      <foo_bar>
        <class>Foo_Bar_Model</class>
    </models>
  </global>

  <frontend> - adminhtml, global
    <events>
      <catalog_product_load_after> - event prefix + action
        <observers>
          <foo_bar> - class group names
            <type>model</type>
            <class>foo_bar/observer</class>
            <method>catalogProductLoadAfter</method>
```

1. Foo/Bar/Model/Observer.php

```
class Foo_Bar_Model_Observer
{
  public function catalogProductLoadAfter(Varien_Event_Observer $observer)
  {
    $product = $observer->getProduct();

    $product->setName( $product->getName() . ' is cool!!!' );
    // is cool se dodaje samo u front end ne i u DB ili admin sekciju
  }
}
```

---

---

Section 3. Lesson 1. Request Flow
=================================

Postoji jos jedan kompleksan Request Flow Diagram, ali
to je tesko pretvoriti u belesku.

Visitor >>
1. index.php
2. Mage.php
3. Mage::run()
4. app/
  * inicijalizacija config/
  * request/stores initialization
  * routing

REQUEST FLOW:
1. Web server
2. Index.php
3. Mage::run()

PHP Setup:
* php.ini
* .htaccess
* index.php

---

### Lesson 2. Front Controller

Mage::app() inicijalizuje Magento enviroment i nakon toga
delegira odgovornost ka Front Controleru.

*Front Controller*
1. Gathers all routes
  * Sve se to desava u init(), tu se gradi array za sve route

2. Apply DB url rewrite
  * U dispatch() > Mage::getModel('core/url_rewrite')->rewrite()

3. Apply configuration url rewrite
  * $this->rewrite() ovo apply nase rewrite // deprecated!

4. Matching exact router
  * while petlja prolazi kroz svaku route i proverava da li postoji

5. Sending output generated by ctrl
  * $this->getResponse()->sendResponse(), return $this


_Front Controller Diagram_
Visitor >>
1. index.php
2. Mage.php
  * Mage::run()
  * Mage_Core_Model_App::run()
    1 this->initEnviroment()
    2 this->initConfig()
    3 this->initCache()
    4 this->initModules()
    5 this->applyUpdates()
    6 Mage_core_Controller_Varien_Front::dispatch()
      * router::match() >> Provera ROUTE
      *  USER dobija << this->getResponse()->sendResponse()


> TIP
> Ukoliko je aktivirano CACHING (Mage::run()\__cache->processRequest())
> Onda se preskace routing i ucitava cachirana strana.


LOKACIJA:
Mage_Core_Controller_Varian_Front

EVENTS:
Mage_Core_Controller_Varian_Front
Mage::dispatchEvent > skoro sve u tom fajlu sa ovim call je neki builtin event.

---

### Lesson 3. Url rewrites

**URL KEY**
Ovo je nesto slicno kao rails named routes.
Omogucava da izaberemo custom keyword za odredjeni URL
nezavisno od Magento generisanog imena:
/product/category/view/10 >> /smartphones

* Korisno za google SEO

DB Rewrites Diagram (jos jedan komplikovan dijagram)


URL Rewrite - Admin panel
>> Catalog/Url rewrite management
1. ID
2. Store (npr english)
3. Type (custom ili system)
4. ID path
5. Request path - custom ime
6. Target path - magento generisan path

DB LOKACIJA ZA URL REWRITE
core_url_rewrite Table

---

EXERCISE - Kreiraj product/category i uradi url rewrite

Admin:
Catalog > Add Product
  - Popuni polja (ima tu i vise tabova, obrati paznju na obavezna polja
    i tabove, Inventory tab itd..)
  - Verovatno ima opcija za rewriteovanje


---

### Lesson 4. Request Routing

REQUEST FLOW
1. *Mage* app is instantiated
2. It instantiates *Front Controller* obj
3. FrontController instantiates *routers*
4. Routers checks the *requests URL* to match patterns
5. If match is found *action controller* instantiates and calls *action name
   calls*
6. Controller action instantiates *layout obj*
7. Layout obj generates the *nested blocks tree*
8. Laoyt starts *rendering*
9. *Blocks* refer directly to the models to obtain *data*


##TYPES OF ROUTERS
* ADMIN
  - Admin backend req
  - Mage_Core_Controller_Varien_Router_Admin

* STANDARD
  - Frontend scope req
  - Mage_Core_Controller_Varien_Router_Standard

* CUSTOM
  - Veoma se retko koriste u Magentu, samostalno definisane

* DEFAULT
  - 404 page
  - Mage_Core_Controller_Varien_Router_Default


SYSTEM ENDPOINT
* Svi req idu ka index.php
* Routes salju routing req odgovarajucem ctrl


MATCHING APPROPRIATE ROUTER
1. index.php
2. Mage::run()
3. Mage_Core_Controller_Varien_Front::dispatch()
  * Custom_Router
  * Router_Admin
  * Router_Standard
  * Cms_Router


MATCH PRIMER
Request > Router::match()
1. False - nista ili default route
2. True > Controller::dispatch($action)


EXECUTING CTRL ACTION
1. Change request obj
$request->setModuleName($module)
$request->setControllerName($controller)
$request->setActionName($action)
$request->setControllerModule($realModule)


2. Call ctrl instance
$request->setDispatched(true)
$controllerInstance->dispatch($action)


APP/ETC/CONFIG ZA ROUTER
``
<config>
...
  <stores>
    <default>
      <web>
        <routers>
          <admin>
            <area>admin</area>
            <class>Mage_Core_Controller_Varien_Router_Admin</class>
          </admin>
          <standard>
            <area>frontend</area>
            <class>Mage_Core_Controller_Varien_Router_Standrad</class>
          </standard>
```

---
##URL COMPOSITION

$baseUrl/$frontName/$controllerName/$actionName/$otherParams

> http://magento.com/cms/install/createuser
> > Module name:     cms (frontName)
> > Controller name: install
> > Action name:     create user


DEFAULT za standard router(magento.com) je CMS.
Ovde mislimo na homepage.
> Admin
> System>Configuration/Web> Default pages> Default Web URL


URL TOOLS
1. Redirect in actions
   $this->_redirect('checkout/cart')

2. Redirect in other places
   Mage::getUrl($path, $arguments)

3. Internals
   Mage_Core_Model_Url
   ``
   $route = Mage::getModel('core/url')
      ->setRouteName('checkout')
      ->setControllerName('cart')
      ->setActionName('index')
      ->getActionPath()
    ```

4. Direktno ka linku
   $this->_redirectUrl('http://www.google.com')

---

ACTION IN CTRL
1. Procesuira request parametre
2. Inicijalizuje blockove
3. Podesava layout
4. Priprema response obj
5. Procesuria exceptions
6. Renderuje layout ako je neophodno

> U Magentu ctrl NE SME da sadrzi logiku.
> Sva logika se mora nalaziti u models/helpers

---

XML Config za kreiranje URL za kontroler:
``
<config>
  <frontend>
    <routers>
      <cms>
        <use>standard</use>
        <args>
          <module>Mage_Cms</module>
          <frontName>cms</frontName>
```
**Mage/Catalog/controllers/**


XML Config URL kontroler REWRITE:
``
<frontend>
  <routers>
    <catalog>
      <args>
        <modules>
          <My_Module before="Mage_Catalog">My_Module_Catalog</My_Module>
```
**My/Module/controllers/Catalog/...Controller.php::...Action()**

---

EXERCISE - ROUTING

Module with Ctrl, echo 'Hello World', override.

1. app/code/local/Foo/Bar/etc/config.xml
``
<config>
  <frontend> - ili admin
    <routers>
      <foo_bar> - class groupname
        <use>standard</use>
        <args>
          <module>Foo_Bar</module> - app/etc/modules/ ime iz Foo_Bar.xml
          <frontName>foo</frontName> - ovde se devinise custom route

```

2. site.com/foo(/index/index)

Foo/Bar/controllers/
frontName  = foo (za to je editovan config.xml)
controller = index (IndexController.php, Klasa: Foo_Bar_IndexController)
action     = index (indexAction())

3. Foo/Bar/controllers/PastaController.php
``
class Foo_Bar_PastaController extends Mage_Core_Controller_Front_Action {
  public function sleepAction(){
    echo '<h1>Im so tired after eating pasta</h1>'; // Hello world
  }
}
```
> site.com/foo/pasta/sleep

4. Rewrite catalog/category/view/
* frontname = catalog
* ctrl      = category
* action    = view

app/code/local/Foo/Bar/etc/config.xml
``
<config>
  <frontend>
    <routers>
      ...
      <catalog>
        <args>
          <modules>
            <foo_bar before="Mage_Catalog">Foo_Bar_Catalog</foo_bar>
```

5. Foo/Bar/controllers/Catalog/CategoryController.php
* require_once se koristi da bi se extendovao/rewriteovao ORIGINALNI ctrl
  (proveriti da li postoji neki kraci/lepsi nacin)
``
require_once 'app' . DS . 'code' . DS . 'core' . DS . 'Mage' . DS . 'Catalog'
. DS . 'controllers' . DS . 'CategoryController.php';

class Foo_Bar_Catalog_CategoryController extend Mage_Catalog_CategoryCOntroller {

public function viewAction() {

    die('ovo radi!');
  }
}

``
> site.com/catalog/category/view/
>> ovo radi!

---

### Lesson 5. Modules Initialization

1. Declaration (app/etc/modules/Ime_Modula.xml)

``
<config>
  <modules>
    <Enterprise_Reward>
      <active>true</active>
      <codePool>core</codePool>
      <depends>
        <Mage_Customer/>
        <Mage_Checkout/>
``

2. Code Pool
  * core
  * community
  * local

3. Class groups
  global/models/classgroup-name

---

EXERCISE

1. Create a new module (folders, 2 cfg xml)
  * app/etc/modules/Day_Two xml
``
  <config>
    <modules>
      <Day_Two>
        <active>true</active>
        <codePool>local</codePool>
``



2. Register class group for models, blocks, helpers
  * app/code/local/Day/Two/etc/config.xml

```
  <config>
    <global>  SCOPE
      <blocks>
        <day_two> = CLASS GROUP ili group name (sinonimi)
          <class>Day_Two_Block</class> = Class name, path
        </day_two>
      </blocks>

      <helpers>
        <day_two> = Group name
          <class>Day_Two_Helper</class>
        </day_two>
      </helpers>

      <models>
        <day_two> = Group name
          <class>Day_Two_Model</class>
        </day_two>
      </models>

``

3. Create empty model file in Model folder
  * /Day/Two/Model/Naziv.php

4. Extend it from Mage_Core_Model_Abstract
  * class Day_Two_Model_Naziv extends Mage_Core_Model_Abstract
  * to vazi za sve modele

5. Register frontend router
  * /Day/Two/etc/config.xml
  ``
  <frontend>
    <routers>
      <day_two>
        <use>standard</use>
        <args>
          <modules>Day_Two</module>
          <frontName>nasa_route</frontName>
  ```

6. Create a controller in your module
  * Day/Two/controllers/IndexController.php
``
  class Day_Two_IndexController extends Mage_Core_COntroller_Front_Action
  {
    public function indexAction()
    {
      echo ' Ovo sada radi! frontName > nasa_route ';
    }
  }
``

  * za ctrl naziv classe nije full path, vec se poziva sa _NazivController kao
    sufix, on auto trazi u controllers/

7. Get the model instance using Mage::getModel()
  * u okviru IndexController dodajemo novu akciju
  ``
  public function modelAction()
  {
    echo get_class(Mage::getModel('day_two/whatever'));
  }
``
  * Day/Two/Model/Whatever.php
    class Day_Two_Model_Whatever extends Mage_Core_Model Abstract

  * pristupamo sa: localhost/.../nasa_route/index/model
    frontName/ctrl/action

8. Make your module depenent from Mage_Log, ovo je stariji modul koji se nalazi
   u Mage_All.xml
  * Day_Two.xml
  ``
  <depends>
    <Mage_Log />
  </depends>
  ``

9. Disable Log module and verify your module doesnt work anymore
10. Enable back Log module and disable your own module
  * uglavnom se svodi na zezanje sa <active> u Day_Two.xml i Mage_All.xml

11. Enable your module but disable all local modules
  * Admin backend postoji neka opcija ali nije najjasnije


---

### Lesson 6. Design and Layout initialization

VIEW:
Renders model into a form suitable for a UI elements.

MAGENTO VIEW:
Layout XML > Block > Template

---

LAYOUT
Konfiguracioni XML file. Compilation of the response from highly reusable UI
elements called **view blocks**.

Organizovani su u *tree structures* koji sadrze razne *view blocks*.

DODAVANJE LAYOUT U MODUL
/etc/config | layout>updates
``
...
<config>
  <modules>
    <Mage_Catalog>
      <version>1.0</version>
...
<frontend>
  <layout>
    <updates>
      <catalog>
        <file>catalog.xml</file>
```

LAYOUT FALLBACK

1. app/design/frontend/enterprise/[THEME]/layout.catalog.xml
>>
2. app/design/frontend/enterprise/default/layout/catalog.xml
>>
3. app/design/frontend/base/default/layout/catalog.xml * fallback

---

EXERCISE DESIGN AND LAYOUT

1. app/code/local/Day/Two/controllers/IndexController.php
``
// site.com/frontname/layout
public function layoutAction()
{
  $xml = $this->loadLayout()->getLayout()->getUpdate()->asString();;

  $this->getResponse()->setHeader('Content-Type', 'text/plain')->setBody($xml);

  Mage::log($xml, Zend_Log::INFO, 'layout.log', true);
  // (data/text, tip, fajl, force loging)
  // var/log/layout.log
}

public function defaultAction()
{
  $this->loadLayout()->renderLayout();
}
```

> Mage_Core_Model_Layout
> Glavna klasa za layout


---

### Lesson 7. Role of Template in Request Flow

* REQUEST FLOW
Init
|
App
|
FrontEnd
|
Controller\
|         --> Models - DB
Rendering /
|
output


OUTPUT (BLOCK)
To je 'najdalji'(najspoljasnjiji) block SVI ostali blockovi su _child blockovi_.

CHILD BLOCK
Uokviru phtml fajla odgovarajuci template se poziva sa:
getChildHtml(name)


LOKACIJA
* app/design/frontend/
  * package/theme/template/ (jos postoje i: layout, etc, locale)
    * page/1column.phtml


---

### Lesson 8. Flushing Output

FLUSHING OUTPUT
Init (layout config)
> Generate page - layout.xml
  > Generate Block
    > Execute output blocks
      > include template
        > Execute _child block_
          > Flushing output


Mage_Core_Controller_Varien_Front
dispatch()

#### REKURZIJA
Svaki template/child block se rekurzivno ponavlja i kreira **response**.
(string)  Npr u head blocku pozivamo neki js block koji opet poziva neke
pod-blockove i to se ponavlja za sve blockove i pod-blockove.

To se desava zahvaljujuci dispatch().
On uzima getRequest() i generise response obj.

---

JS & CSS

Postoji mogucnost _flushinga_ (to se jos zove **concatenation**),
on sve js/css fajlove kombinuje u jedan.

---
---

# SECTION 4
# Rendering System

### Lesson 1. Overview


DESIGN ELEMENTS
* Skin
> Visual layout info and files, UI specific JS
  1. css
  2. img
  3. js

* app/design
  1. layout - Page generation xml instructions for each module
  2. template - content block .phtml


TEMPLATE STRUCTURE
* phtml
  Sadrzi _structural blocks_

* layout files.xml
  Ovde se formira struktura _view_ i ucitavaju se template (phtml) blockovi


THEME RULES TIPS
* single layout file (local.xml), where all layout updates are placed
* no layout files with the same name as any layout file in the base theme
* no css files with the same name as any css in default skin
* no .phtml template files, except those that were modified to support new
  theme


THEME CONFIG ADMIN
app/design/frontend/**package**/
Postoji posebno polje za podesavanje theme.


DIR STRUCTURE
* Skin
  * skin/frontend/
      > /base - base design package
      > /default - default theme

* Design
  * app/design/frontent/
    > base - base design package
    > default - default theme


WHAT ARE THEMES
1. Visual aspect of site design (SKIN)
  * css, img, design/user specific js

2. Odredjene funkcionalne aspekte sajta
  * npr. koji default block/module je dostupan (LAYOUTS)
  * koji podaci se prikazuju i kako (TEMPLATES)

3. Omogucava da *presentation layer* bude nezavistan od poslovne logike
   i funkcionalnosti



DESIGN PACKAGES
* package
  * base
    * default
    * sve ostalo je non-default


STORE DESING CONFIG
Menjamo admin store na neku novu themu.
``
<stores>
  <admin>
    <design>
      <package>
        <name>default</name>
      </package>
      <theme>
        <default>newtheme</default>
        <skin>newtheme</skin>
```

---

EXERCISE. Create your own theme

1. Create new theme, register
  * Admin/design
    * default: training (to je naziv theme)

  * mkdir app/design/frontend/[package]/training/template

2. override page/1column.phtml template
  * copy 1column.phtml from [package]/default/page/...

  * 1column.phtml mora da ima *isti path*
    * /training/template/page/1column.phtml

  * dodati <h1>blabla</h1> bilo gde u template

* Objasnjen je i jedan primer o hijerarhiji/priority thema.
  U admin>templates je dodat highest. I tu je ponovo uradjena ista
  modifikacija.
  Ta modifikacija je sada postala **glavna**, a default: training je postao
  default fallback


> TIP
> Developer/Debug/
> Opcija PROFILER, prikazuje sve layout.xml detalje na samom view u browser.
> Template path i block names su trazene opcije.
> Neophodno je podesiti SCOPE, tj. prodavnicu da bi radilo.


PRIMER
Za sekcije templates (getChildHtml('header') u phtml template), gde se nalaze.

...page.xml
<block type=page/html_header name=header as=header> Mage_Page_Block_Html_Header.php


**BITNO**
<block> node ustvari poziva createBlock() svaki put.
Block moze da se kreira u:
1. direktno u ctrl
2. ili negde u layout.xml
3. ili getLayout()->createBlock() u template

**getLayout() UZIMA LAYOUT OBJECT (Mage_Core_Model_Layout)**

---

EXERCISE. Create package

1. Create and register new package
  * Admin/Design - change scope
  * mkdir app/design/frontend/custom_pkg
  * package name: custom_pkg, samo ovo ne ucitava css/img/js

  * copy enterprise/default > custom_pkg/default
  * mkdir skin/frontend/custom_pkg
  * copy skin/enterprise/default > skin/custom_pkg/default

2. Verify that base/default fallback is used
3. Copy enterprise/default theme to new package/default - OK
4. Verify that new package/default is used
5. Copy enterprise/your theme to new package/your theme - OK
6. Verify that your theme is used

> TIP: Fallback (za template,layout,skin)
> Start = app/design/frontend/
> 1. custom_pkg/highest/template // ovo smo definisali u proslom primeru
>    u sekciji template
> 2. custom_pkg/training/template,layout,skin // takodje u proslom u sekciji
>    default
> 3. custom_pkg/default/template,layout,skin
> 4. ..base/default


---

EXERCISE. Create a fallback theme

1. mkdir custom_pkg/custom/template/page/
2. copy design/frontend/enterprise/default/page/1column.phtml
   > custom/template/page/1column.phtml
   * edit file: h1>Custom package, custom theme
3. ovde je promenio scope na french, dodao je u template: custom  (umesto
   highest)

4. Primary theme: custom_pkg/primary/ ... isto sto i prethodno (dir za
   template, fajl phtml...)
  * Admin, scope: default
    * design/templates: primary

---

RECURSIVE VIEW

1. catalog/product_view - glavni block (mislim da se ovo odnosi na layout.xml)
2. unutar njega: catalog/product_view_media,product_list ... to su sve
   templates koje se ucitavaju u glavni block

---

EXERCISE. Add hello world to price template

1. app/design/base/default/template/catalog/product/price.phtml
  * SPECIAL TEMPLATE, veoma kompleksan
  Da bi radilo dodaj 'hello world' na kraju fajla.
  (iskopirati ovaj path/file u custom_pkg/nazivtheme)

---
---


### Lesson 2. Magento Blocks

BLOCKS
Base unit in Magento design.
Vise blockova cini page.


#### STRUCTURE OF BLOCKS
* Custom_Block
  * Mage_Core_Block_Template (Ovo se najcesce koristi)
    - #_template - odavde se poziva template?
    - setTemplate()
    - getTemplateFile()
    - toHtml()
    - Osnovan klasa je:
      1. Mage_Core_Block_Abstract (osnovan klasa)
        getChild()
        getChildHtml()
        toHtml()
      2. Template phtml
        <div class="cart">...

#### CONFIG
1. Mage_Catalog blocks
``
<global>
  <blocks>
    <catalog>
      <!-- block group name -->
      <class>Mage_Catalog_Block</class>
      <!-- Maps to Mage/Catalog/Block/ -->
``
2. Myspace_Custom block
``
<global>
  <blocks>
    <custom>
      <!-- block group name -->
      <class>Myspace_Custom_Block</class>
      <!-- Maps to Myspace/Custom/Block/ -->
``

* _Pozivanje:_
1. $block = Mage::app()-getLayout()->createBlock('catalog/product_view')
  // Mage_Catalog_Block_Product_View

2. $block = Mage::app()-getLayout()->createBlock('custom/product_view')
  // Myspace_Custom_Block_Product_View

---

EXERCISE. Create a new page, block, template

1. Create and register controller, set responce body "HELLO WORLD"
``
// app/code/local/Day/Two/etc/config.xml
...
<frontend>
  <routers>
    <day_two> // class group
      <use>standard</use>
      <args>
        <module>Day_Two</modules>
        <frontName>custom</frontName> // ovo je link, localhost/custom
``

``
// Controller
// Day/Two/controllers/RenderController.php // localhost/custom/render
class Day_Two_RenderController extends Mage_Core_Controller_Front_Action
{
  public function blockAction()
  {
    $this->getResponse()->setBody('Hello World!');
  }
}

``


2. Register blocks, create block class, override \_toHtml() method and return
   hello world

   Block config:
   ``
   // app/code/local/Day/Two/etc/config.xml
   <global>
    <blocks>
      <day_two> // class group
        <class>Day_Two_Block</class>
    ``


    Block folders & file:
    Day/Two/Block/Sample.php
    ``
    class Day_Two_Block_Sample extends Mage_Core_Block_Template
    {
      protected function _toHtml() { # overwrite parent f()

        return 'Hello Magento from' . __FILE__;
      }
    }

    ``


3. Add block output to response body
    Override ctrl action:
    ``
    // Day/Two/controllers/RenderController.php
    public function overrideAction()
    {
      $blockHtml = $this->getLayout()->createBlock('day_two/sample')
                            ->toHtml();
      $this->getResponse()->setBody($blockHtml);
    }

    ``

### GENERISANJE
  Ovo je *bitan* poziv, tu se vrsi loadovanje layout obj, i odatle se kreira
  novi block, da bi taj block bio renderovan iz ctrl mora da se pozove toHTML
  $this->getLayout()->createBlock('day_two/sample')->toHtml();



4. Create core/template block and template in custom theme, and in controller
   add output to response body

``
// Day/Two/controllers/RenderController.php
...
public function templateAction()
{
  $blockHtml = $this->getLayout()->createBlock('core/template') # mage block
                        ->setTemplate('day_two/random.phtml')
                        ->toHtml();
  $this->getResponse()->setBody($blockHtml);
}
``

### INFO
Slicno sto i stavka 3 samo sto se ovde podesava i odgovarajuci template za
prikaz.

* Custom template:
setTemplate('path/relative/to/template/\*.phtml')

Lokacija naseg template: (base/default - se uvek odnosi na ceo sajt)
app/design/frontend/base/default/template/day_two/random.phtml
``
<h1>Here is a template and class: <?php echo get_class($this); ?></h1>
``


---

### Kreiraj block bilo gde u applikaciji:
$block = Mage::app()->getLayout()->createBlock('custom/product_view');
---



STAGES OF BLOCK LIFECYCLE

1. Declared in layout or just in code(createBlock())
2. block instance created, then \_prepareLayout() is called
3. renderLayout() called, SYSTEM calls toHtml(), all *children* are rendered
4. \_beforeToHtml(), \_toHtml(), \_afterToHtml()


EVENTS FIRED IN BLOCKS (iz methoda)
* setLayout(...)
core_block_abstart_prepare_layout_before
core_block_abstart_prepare_layout_after

* toHtml()
core_block_abstart_to_html_before
core_block_abstart_to_html_after


TYPES OF BLOCKS
1. Mage_Core_Block_Template **najcesce koriscen**
2. Mage_Core_Block_Text_List **bitan template takodje**
3. Mage_Core_Block_Messages
4. Mage_Core_Block_Flush
5. Mage_Core_Block_Text
6. Mage_Core_Block_Template_Links


#### MAGE_CORE_BLOCK_TEXT_LIST
Posebno je naglasen Text_List block.
...Text_List i Text _direktno_ nasledjuju od Mage_core_Block_Abstarct


..._Text / _Text_List *NE KORISTE* template.

ONI SU NAPRAVLJENI DA BI SE OMOGUCIO DIREKTAN RENDERING U OKVIRU STRUKTURALNIH
BLOCKOVA(ROOT,LEFT,RIGHT,CONTENT ITD..) KOJI AUTOMATSKI RENDERUJE CHILD BLOCKOVE,
A DA TO NIGDE NEMORAMO EXPLICITNO DA DEFINISEMO/POZOVEMO.

Njihov toHtml() renderuje child blockove. (nema potrebe onda za template)

---


DISABLING OUTPUT
``
<config>
  <default>
    <advanced>
      <modules_disable_output>
        <Mage_Cms>1</Mage_Cms>
        <!-- ovo disableuje module Mage_Cms **SAMO output** -->
``

---

BLOCK FLOW
1. Block should be instantated through LAYOUT OBJ
2. Block _should_ extend MAge_COre_Block_Abstart class
3. All models & collections loads should be performed in **\_prepareLayout()**
   method or block constructor. (SETUP)
4. \_toHtml() returns blocks OUTPUT

---

BLOCK PRIMER

``
// retrieve cms as html
public function getCmsBlockHmtl()
{
  if (!$this->getData('cms_block_html')) {
    $html = $this->getLayout()
                 ->createBlock('cms/block')
                 ->setBlockId( $this->getCurrentCategory()->getLandingPage() )
                 ->toHtml();
    $this->setData('cms_block_html', $html);
  }
  return $this->getData('cms_block_html');
}
``

---

BLOCK INSTANTITATION IN ACTION(CTRL)
``
// get specified tab grid
public function gridOnlyAction()
{
  $this->_initProduct();
  $this->getResponse()->setBody(
      $this->getLayout()
           ->createBlock('adminhtml/catalog_product_edit_tab_'
           . $this->getRequest()->getParam('gridOnlyBlock'))
           ->toHtml()
      );
}
``

---

#### GET TEMPLATE FROM THE BLOCK

1. From ctrl:
  $this->getLayout()->getBlock('head')->getTemplate()

2. From an arbitrary place:
  Mage::app()->getLayout()->getBlock('head')->getTemplate()

3. Setting template manually:
  * From inside the block:
    $this->setTemplate('...')
  * From another place:
    Mage::app()->getLayout()->getBlock('head')->setTemplate('...')


#### PASSING PARAMS TO BLOCK

1. From controller:
  $this->getLayout()->getBlock('content')
       ->setParam('..')
       ->setAnotherParam('..')

2. Through the _registry_:
  * from anywhere:
    Mage::register('some_var', 'someval')
  * from inside the block:
  ``
  public function getSomeVar() {
    if(!$this->_someVar) {
      $this->_someVar = Mage::registry('some_var'):
    }
    return $this->_someVar;
  }
  ``


---
PODESAVANJE OBJ VALUES (getters & setters)
Ovo su Varien Obj koji mogu da se koriste bilo gde u codu. (od magento2 ovo
ide out).
$obj->setSomeValue('string')
$obj->getSomeValue()
---


OVERRIDE THE BLOCK (isto kao i za modele)
``
<global>
  <blocks>
    <checkout>
      <rewrite>
        <onepage_link>Training_Catalog_Block_Chekcout_Onepage_Link</onepage_link>
``


BASIC OPERATIONS WITH BLOCKS
* setChild(alias,block)   - adding child to the block
* insert(block)            - adding child to text_list block
* getChild(name)          - getting child of the block
* getChildHtml(name)      - isto sto i getChild(name)->toHtml()
* getChildChildHtml(name, childName) - isto sto i:
    getChild(name)->getChild(childName)->toHtml()


---

EXERCISE 2.

> TIP:MAGE REGISTRY
> Neka vrsta globalnog array za cuvanje podataka.
> Setup:
> Mage::register('some_var', 'Neka vrednost')
> Get value:
> Mage::registry('some_var')


* Vec smo definisali block klasu tako da svi novi blockovi se auto adduju:
``
// app/code/local/Day/Two/etc/config.xml
global>blocks>day_two>class = Day_Two_Block
``

1. In the ctrl register a parameter in the Mage registry
Day/Two/controllers/RenderController.php
``
public function registryAction()
{
  Mage::register('some_var', 'Some value.');

  $blockHtml = $this->getLayout()
                    ->createBlock('day_two/registry')
                    ->setTemplate('day_two/registry.phtml')
                    ->toHtml();

  $this->getResponse()->setBody( $blockHtml );
}
``
site.com/custom/render/registry

2. Create a new block class which returns that value from the registry
``
// Day/Two/Block/Registry.php
class Day_Two_Block_Registry extends Mage_Core_Block_Template
{
  public function getThatRegistryValue()
  {
    $var = Mage::registry('some_var');

    return $var ? $var : 'Nema niceg u registry';
  }
}
``


3. Create a template to output/format the value
  Lokacija naseg template: (base/default - se uvek odnosi na ceo sajt)
  app/design/frontend/base/default/template/day_two/random.phtml

  Ovo nije opisano, ali u template ide $this->getThatRegistryValue();

4. Create a text list block instance
5. Add 2 child blocks to this block using the insert()
``
public function listBlockAction()
{
  // Text list block
  $tlb = $this->getLayout()
              ->createBlock('core/text_list');

  // EMpty blocks
  $blockA = $this->getLayout()
                 ->createBlock('core/text')
                 ->setText('<h1>Block A</h1>');

  $blockB = $this->getLayout()
                 ->createBlock('core/text')
                 ->setText('<h1>Block B</h1>');


  // INsert
  $tlb->insert($blockA)->insert($blockB);

  // Response, vraca render
  $this->getResponse()->setBody( $tlb->toHtml() );



  // Alternativa
  // OVO UCITAVA PRETHODNI REZULTAT ALI U DEFAULT MAGENTO LAYOUT (IZGLED)
  $this->loadLayout();

  $this->getLayout()
       ->getBlock('content')  // page.xml se nalazi, ovo je structuralni block
       ->insert( $tlb );

  $this->renderLayout();

}
``

---

EXERCISE 3. Override block class

Catalog Product View Block

1. app/code/local/Day/Two/etc/config.xml
``
global>blocks>

<catalog>
  <rewrite>
    <product_view>Day_Two_Block_Catalog_Product_View</product_view>

``

2. mkdir Day/Two/Block/Catalog/Product/View.php
``
class Day_Two_Block_Catalog_Product_View extends Mage_Catalog_Block_Product_View
{
  protected function _toHtml()
  {
    return 'It worked!!!';
  }
}

``

---

EXERCISE 4. Breadcrumb

1. Admin
  * Website scope
  * Developer:
    - Template path hints

  * Tu pronalazimo tacan template za trazeni template na nekoj strani.
  frontend/base/default/template/page/html/breadcrumbs.phtml = template
  Mage_Page_Block_Html_Breadcrumbs = klasa

2. Editovati Day/Two/etc/config.xml
``
global>blocks>

<page>
  <rewrite>
    <html_breadcrumbs>Day_Two_Block_Html_Breadcrumbs</html_breadcrumbs>
    // od gorenjeg path za breadcrumbs.phtml

``

3. Dodati novi folder u block za novu block klasu:
  Day/Two/Block/Html/Breadcrumbs.php
  ``
  class Day_Two_Block_Html_Breadcrumbs
    extends Mage_Page_Block_Html_Breadcrumbs
  {
    protected function _construct(){

      $this->addCrumb('google link', array(
              'label' => 'Google',
              'title' => 'Go to the Google',
              'link'  => 'http://www.google.com'
            ));
    }
  }

``

> Za dodavanje funkcionalnosti procitati code od
> Mage_Page_Block_Html_Breadcrumbs
> ovde postoji commentar za array koji je neophodno proslediti u addCrumb(name,
> info_array(sadrzi label,title, link) )


---
---

### Lesson 3. Design, Layout, XML schema


VIEW
1. Layout XML
2. Block
3. Template


LAYOUT USAGE
1. Create a layout of page
2. add/remove blocks to existing pages
3. Call any method of any block on the page - <action method=" ">
4. Set parameters to blocks - setSomeVal() (varien obj)


MODULE LAYOUT UPDATES
U okviru modula (config.xml), ukoliko zelimo da koristimo layout (extend layout), moramo navesti novi node u xml:
``
<frontend>
  <layout>
    <updates>
      <catalog>
        <file>catalog.xml</file> // relative to layout/
``


LAYOUT XML SCHEMA
Svi layout files se **merguju** u jedan veliki xml file.
Postoji fallback mehanizam.


LAYOUT FALLBACK
1. app/design/frontend/enterprise/[THEME]/layout/catalog.xml - THEME

2. app/design/frontend/enterprise/default/layout/catalog.xml - DEFAULT

3. app/design/frontend/base/default/layout/catalog.xml       - BASE/DEFAULT


LAYOUT IN CTRL
Svi layout files se merge-uju u jedan fajl, loadLayout() omogucava da ucitamo
odgovarajuc deo layouta neophodan za neki npr ctrl.

``
public function indexAction()
{
  $this->loadLayout();
  ... (getLayout)
  $this->renderLayout();
}
``

LAYOUT HANDLES
To je bilo koji node ispod <layout>
``
<layout>
  <ovo_je_handle>
  ...
  </ovo_je_handle>
</layout>
``

# LOAD & RENDER LAYOUT

## Mage_Core_Controller_Varien_Action::loadLayout()
* Argumenti
  loadLayout( $handles=null, $generateBlocks=true, $generateXml=true )

Razni methodi: (oni generisu default handles)
* $this->addActionLayoutHandles();
  1. Store handle
  2. Theme handle
  3. Action handle

* $this->loadLayoutUpdates(); // ucitava sve xml fajlove

* $this->generateLayoutXml() // generise veliki fajl

* $this->generateLayoutBlocks() // instanciraj blockove

---

## Mage_Core_Controller_Varien_Action::renderLayout()
* Argumenti:
  renderLayout($output='') - ovo znaci da ukoliko nije prosledjen neki
  output/template itd... ovo prikazuje samo prazan string

* Razni methodi: sadrzi vise dispatchEvent (render_before)
  1. getResponse()->appendBody($output) - **najbitniji** ovo se ubacuje
     u response body(obj) i spremno je za slanje ka browseru

---


EXERCISE. Layout XML

1. Register a layout in your module
module.../etc/config.xml
``
<frontend>
  <layout>
    <updates>
      <acez_layout> - poseban node
        <file>day_two/custom.xml</file> - relativno u odnosu na layout
        (frontend/layout)
``

app/design/frontend/base/default/layout/day_two/custom.xml
``
<layout>
  <default ili naziv catalog_product_view> - layout handle
    <reference name="content"> - reference block
      <block type="core/text" name="oops"> - novi block,definicija, deklaracija
        <action method="setText">
          <arg>This is some random text!</arg>

``

app/code/local/Day/Two/controllers/RenderController.php
``
public function layoutAction()
{
  $this->loadLayout()->renderLayout(); // site.com/[custom]/render/layout
}
``


2. add a core/template block to 'content'block in default handle

3. on product details page reference your block and set a value using action,
   output this value in template

5. primer gde se modifikuje:
design/frontend/base/default/catalog.xml
block_type: catalog_product_view
name iz block: product.info
template: catalog/product/view.phtml

``
<reference name="product.info"> - na koji block se odnosi promena
  <action method="setThisDoesntExist">
    <abcdefg>This is a string!</abcdefg>
    // ili kao array
    <abcdefg>
      <key1>Ovo je string od array1</key1>
      <key2>Ovo je drugi string za isti array</key2>
``

Vec smo ranije customizovali template:
design/frontend/custom_pkg/primary/template/catalog/product/view.phtml
> dodati negde u template echo $this->getThisDoesntExist()

---

LAYOUT XML BASIC DIRECTIVES

1. reference  = reference content will be *merged* **into** target block, attr
 "name" specifies the **referenced** block name

2. block      = block **declaration**

3. action     = pozivanje bilo kog methoda iz *target blocka*

4. update     = merge to the current handle ALL directives from target handle,
                (include)

5. remove     = set 'ignore' flag for the *target* block, doesnt remove

6. contact_index_index = ctrl action **alias** name. Block in this node will be
 showed when: site.com/contacts/index/index is accesses.

---

BLOCK DIRECTIVE (2)
``
<block type="core/template"
       name="some.string"
       as="alias.string"
       parent="content"
       template="some/file.phtml"
       output="toHtml"></block>
``
1. type attribute = block class name used for factory method

2. name = name by which other blocks can make *reference* to the block in which this attribute is assigned

3. as = block alias

4. parent = parent block name, used for adding current block into the parent block

5. before = block name or - , used for adding current block before the block name specified (

6. after = block name or - , used for adding current block after the block name
   specified

7. template = template phtml FILE path

8. output = method for block output *rendering* (default: output="toHtml")

* BITNO: ALIAS(AS) vs NAME
Bitan je kontekst gde se koristi. U okviru *parent blocka* koristimo alias,
a svugde ostalo *name*.

---

ACTION DIRECTIVE (3)
``
<block type="page/html_head"> - ili reference je druga opcija
  <action method="addJs"/> - addJs() je definisan u page/html_head blocku
  <helper="catalog/map/getCategoryUrl"/>

</block|reference>
``
1. method = block method name

2. translate = attribute used for method arguemtns translation?
   odnosi se na neke nodove unutar actiona, ucitava odgovarajuci modul za neki
   xml node, ovo je za jezike (povezano sa locale csv fileovima)

3. module = Na koji module se odnosi?

4. helper = Helper name with helper method
   helper="catalog/map/getCategoryUrl"
   = classgroup_name/helper/map.php::getCategoryUrl()

5. json = json value for decoding. All decoded values will be passed to the
   block method.

6. ifconfig = checking configuration flag in order to allow/deny processing
    ifconfig="catalog/seo/site_map" - proverava konfiguracionu opciju (ovde iz
    admin)


REFERENCE DIRECTIVE (1)
Ovo samo uzima neki block i u njega ubacuje reference nodeove.
``
<reference name="root">Ubaci nesto u root block</reference>
``


REMOVE DIRECTIVE (6)
Ukoliko ne zelimo da koristimo neke blockove u template.
Takodje svi *podblockovi* se nece instancirati.
``<remove name="right"/>``


UPDATE DIRECTIVE
ovo ucitava neki handle/block i dodaje ga.
Ovo omogucava lakse odrzavanje jer ukoliko se taj block promeni svugde je
ucitana aktuelna verzija.
Ovo je neka vrsta *INCLUDE* za layoute.
``<update handle="customer_accoutn_login"/>``


---

EXERCISE 2. Set up your own handle

1. Create your own handle in layout xml file, add output block to handle:

design/frontend/base/default/layout/day_two/custom.xml
(ovo se poziva iz Day/Two/etc/config.xml <layout><updates>...)

``
<layout>
  <cool_handle> - bilo koji node ispod layout je handle
    <block type='core/template' name='some.name' output='toHtml'
      template='some/template.phtml' />

``

design/frontend/base/default/template/some/template.phtml
``
<h1>This is  Some template!</h1>
``

2. In ctrl add a new action and call:
   $tihs->loadLayout(_yourhandle_)->renderLaoyt()

app/code/local/Day/Two/controllers/RenderCOntroller.php
``
public function handleAction()
{
  $this->loadLayout('cool_handle')->renderLayout();
}
``
site.com/custom/render/handle


---
PRIMER ZA AUTOLOADOVANJE:

app/code/local/Day/Two/controllers/RenderCOntroller.php
``
public function finalAction()
{
  $this->loadLayout()->renderLayout(); // auto pronalazi odgovarjuci template
}
``
site.com/custom/render/final

design/frontend/base/default/layout/day_two/custom.xml
(ovo se poziva iz Day/Two/etc/config.xml <layout><updates>...)

``
<layout>
  <cool_handle> - bilo koji node ispod layout je handle
    <block type='core/template' name='some.name' output='toHtml'
      template='some/template.phtml' />


SPECIFICNO!
foobar_render_final je naziv naseg handle koji se AUTO loaduje i tako da bi
se prikazao nas sadrzaj iz cool_handle moramo da ga povezemo sa foobar_.
(Znaci da loadLayout() bez argumenata auto odnosi na foobar_render_final)
..
  <foobar_render_final> - route node, ctrl, action
    <update handle='cool_handle' /> - ovo samo includuje nas gornji block

``

---
CHILD BLOCK

design/frontend/base/default/layout/day_two/custom.xml
(ovo se poziva iz Day/Two/etc/config.xml <layout><updates>...)

``
<layout>
  <cool_handle> - bilo koji node ispod layout je handle
    <block type='core/template' name='some.name' output='toHtml'
      template='some/template.phtml' >

      <block type='core/text' name='some.otherBlock'> - child block
        <action method='setText'>
          <argu>Some random text!</argu>
        </action
    </block>

``

* Mora da se podesi template jer core/text NEMOZE da bude child od
  core/template, core/text JEDINO moze da renderuje svoje children
design/frontend/base/default/template/some/template.phtml
``
<h1>This is  Some template!</h1>
<?php echo $this->getChildHtml('some.otherBlock'); ?> // ovo mora da bi
prikazao child block iz layout-a
``


3. Add update node to include your layout update handle in cms_index_index
Mi smo uradili ali za nas layout (custom.xml)

---

EXERCISE 3. Move block

Vrsimo pomeranje Poll blocka (base/default/layout/poll.xml - naziv right.poll)
sa right na left strukturalni block.

* Ovde smo iskoristili nasu custom theme (custom_pkg)

1. Podesiti layout u admin/system/config/design
Layout = primary

2. app/design/frontend/base/custom_pkg/primary/layout/local.xml

OBJASNJENJE:
* Ovde pozivamo unsetChild method i prosledjujemo mu name argument (right.poll)

* Remove layout komanda ovde neradi jer kad se jednom removuje onda vise nemoze
  ponovo da se poziva taj block, tako da moramo da koristimo unsetChild.

* U enterprise verziji postoji search.xml (default/layout/), on remove-uje catalog.leftnav, koji
  nam je neophodan za prikaz. Bitno je da se nas kod nalazi u odgovarajucem
  layout handle. (catalog_category_layered)

* insert($blockname, $sibilingName), <sibiling> se odnosi na drugi argument

``
<layout>
  <default>
    <!-- prvo ukloni block sa unsetChild -->
    <reference name="right"> - strukturalni block
      <action method="unsetChild"><name>right.poll</name></action>
    </reference>

    <!-- ovde dodaj block na left -->
    <!-- SA DEFAULT NE RADI -->
    <reference name="left">
      <action method="insert">
        <name>right.poll</name>
        <sibiling>enterprisecatalog.leftnav</sibiling> - specificno za
        enterprise verziju
      </action>
    </reference>

  </default>

  <!-- OVAKO JE TREBALO, MORA DA SE TARGETUJE HANDLE -->
  <!-- ovde dodaj block na left -->
  <catalog_category_layered>
    <reference name="left">
      <action method="insert">
        <name>right.poll</name> - prvi argument
        <sibiling>enterprisecatalog.leftnav</sibiling> - drugi argument
      </action>
    </reference>
  </catalog_category_layered>

</layout>
``


---
---


# Section 5. DB in Magento

## Lesson 1. Overview

MVC
U Magentu vecina **logike** se nalazi u _modelima i views_.


### Storing data
1. Entity based approach
  Svaki row u db predstavlja kompletnu informaciju o nekom entity. (speadsheet)

2. Model Layer in Magento
  * Model
    Omogucava CRUD operacije
  * Resource Model
    Modeli komuniciraju sa DB uz pomoc _resource modela_, koji ima pristup DB adapterima.
  * Collection
    Ovo omogucava manipulaciju sa vise records u OOP maniru



### Storage Types Magento
1. Simple Model (flat)
  Ovo je najjednostavniji tip, svaki row ima kompletnu informaciju o nekom
  entitetu. (Store, Website, URL Rewrites....)

2. Complex Model
  Ovde se informacije o nekom entitety cuvaju u vise tabela, relacione tabele.
  Najslicnije onome sto smo do sada radili.
  (CMS Block/PAge, Quote, Order...)

3. EAV Model
  Entity Attribute Value Model, primer:
    Tradicionalne db tabele imaju fixan broj columns, i menjanje/dodavanje
    columns cesto znaci menjanje logike.

    EAV is used because it much more scalable than the usual normalised
    database structure. Developers can add attributes to any entity (product,
    category, customer, order etc) without modifying the core database
    structure.
    When a custom attribute is added, no logic must be added to
    force Magento to save this attribute because it is all already built into
    the model; as long as the data is set and the attribute has been created,
    the model will be saved!

    In Magento the entity, attribute and values are stored in different tables.
    The tables are linked to each other by foreign key.



### Data Access
(nazivi nemaju veze ni sa cim)

1. Basic
  DB  <<  DB Adapter << Model
  * db adapter je apstrakcija koja uklanja sql komande iz modela i omogucava
    manipulaciju podacima na OOP nacin.
    On takodje omogucava komunikaciju na nacin koji je **db agnostic**, tacnije
    u potpunosti je nevezan za tip storage engina (isti kod ce raditi i u mysql
    i postgres i bilo kom drugom db sistemu koji je podrzan od strane adaptera)

2. Bad model
  DB << Model
  * Lose strane ovoga su, SQL komande moraju da se unose u model, u potpunosti
    je vezan za storage engine (npr sa mysql nemoze da se prebaci u postgre bez
    rewritovanja)

3. Generic
  DB << DB Adapter << Resource Model << Model
  * Dodatni stepen apstrakcije

4. Simple
  DB << DB Adapter << Resource Model + Resource Collection << Model


---

### Model Declaration

#### ENTITY MODEL

* Configuration Entity Model:
  U odgovarajucem modulu editovati config.xml:
  ``
  <global>
    <models>
      <mymodule> <!-- class group name; unique -->
        <class>Mycompany_Mymodule_Model</class>
        <!-- path: Mycompany/Mymodule/Model/  ... -->
  ``
* Using Entity Model, instantiate:
  ``
  $model = Mage::getModel('catalog/product' [,$args]) // instance

  $model = Mage::getSingleton('catalog/product' [,$args]) // singleton
  ``

#### RESOURCE MODEL
* Configuration Resource Model:
  U odgovarajucem modulu editovati config.xml:
  ``
  <global>
    <models>
      <mymodule> <!-- class group name; unique -->
        <class>Mycompany_Mymodule_Model</class>
        <!-- path: Mycompany/Mymodule/Model/  ... -->
        <resourceModel>mymodule_resource_eav_mysql4</resourceModel>
      </mymodule>

  ...

  <mymodule_resource_eav_mysql4>
    <class>Mage_Catalog_Model_Resource_Eav_Mysql4</class>
      <entities>
        ...
      </entities>
  </mymodule_resource_eav_mysql4>
  ``

* Using Resource Model, instantiate:
  ``
  $resourceModel = Mage::getResourceModel('catalog/product')
  ``
  Ovo dokazuje samo da se resource model poziva isto kao i obican model, ali da
  resource model se odnosi interno na drugi node u xml.
  (Mage_Catalog_Model_Resource_Eav_Mysql4_Product je class)


#### RESOURCE MODELS (MAGE)

Razlika izmedju Mage_Customer i Mage_Catalog.
Oni se odnose na resource modele ali razlicite naming konvencije koriste.

1. Mage\_Customer
  ``
  <global>
    <models>
      <customer> <!-- class group -->
        <class>Mage_Customer_Model</class>
        <resourceModel>customer_entity</resourceModel>
      </customer>

      <customer_entity> <!-- definicija za resource model -->
        <class>Mage_Customer_Model_Entity</class>
        <entities>
          ...
        </entities>
      </customer_entity>
    </models>
  </global>
  ``

  Pristup:
  ``
  $resModel = Mage::getResourceModel('customer/nesto');
  // Mage_Customer_Model_Entity_Nesto - Class
  ``

2. Mage\_Catalog
  ``
  <global>
    <models>
      <catalog> <!-- class group -->
        <class>Mage_Catalog_Model</class>
        <resourceModel>catalog_resource_eav_mysql4</resourceModel>
      </customer>

      <catalog_resource_eav_mysql4> <!-- definicija za resource model -->
        <class>Mage_Catalog_Model_Resource_Eav_Mysql4</class>
        <entities>
          ...
        </entities>
      </catalog_resource_eav_mysql4>
    </models>
  </global>
  ``

  Pristup:
  ``
  $resModel = Mage::getResourceModel('catalog/product');
  // Mage_Catalog_Model_Resource_Eav_Mysql4_Product - Class
  ``




#### PRISTUP RESOURCE MODELIMA
Ukratko razmisljati na sledeci nacin:
``
Mage::getResourceModel('catalog/product');
``
1. Ulazi u config.xml od modula (catalog)
2. Trazi class group name <catalog>
3. U njemu trazi <resourceModel>ime_resourse_klase</resourceModel> node
4. Nakon sto je pronasao <resourceModel> node onda skace na node kojim se
   definise taj resource model: <ime_resourse_klase>
5. U tom nodu se nalazi <class>Ovo_Je_Klas_Prefix</class> i <entities>
6. 'catalog' je zasluzan za class prefix, a '/product' za naziv konkretnog
   resource modela
7. Rezultat: Ovo_Je_Klas_Prefix_Product




#### Entities Declaration in Resource Models
Entity = Tables
Oni se definisu u okviru resource model definition node-a.

``
<catalog_resource_eav_mysql4>
  <class>Mage_catalog_Model_Resource_Eav_Mysql4</class>
    <entities>
      <product><table>catalog_product_entity</table></product>
      <category><table>catalog_category_entity</table></category>
      <category_product><table>catalog_category_product</table></category_product>
      ...
``

* Pristup UCITAVANJE TABELE:
  ``
  $resModel
  = Mage::getResourseModel('catalog/product')->getTable('catalog/product');
  // catalog_product_entity
  ``



#### Resource Collection Model Declaration

Nemora nista da se radi niti podesava za dobijanje kolekcije.

1. config.xml - je isti
2. mora da se doda Collection/ na odgovarajuce mesto (Models/)

* Magento putem kolekcija omogucava da se trazeni obj loaduje _samo_ jednom.

* Prilikom pozivanja resourcemodela jedino treba da se doda \_collection:
  ``
  // Single model
  $product = Mage::getResourceModel('catalog/product');

  // Collection
  $product_collection = Mage::getResrouceModel('catalog/product_collection');
  ``




#### Model-to-Resource PHP
Kako se povezuje model sa resource uokviru php klase:

``
class Mage_Catalog_Model_Product
  extends Mage_Core_Model_Abstract
{
  protected function _construct()
  {
    $this->_init('catalog/product'); // ovo je obavezan korak, inicijalizacija
  }
}
``

``
// MAGENTO Background za _init ...
class Mage_Core_Model_Abstract extends Varien_Object
{
  protected function _init($resourceModel)
  {
    $this->_setResourceModel($resourceModel);
  }

  protected function _setResourceModel($resourceName,
  $resourceCollectionName=null)
  {
    $this->_resourceName = $resourceName;

    if (is_null($resourceCollectionName)) {
      $resourceCollectionName = $resourceName . '_collection';
    }

    $this->_resourceCollectionname = $resourceCollectionName;
  }
}
``



#### Model-to-Collection
``
Mage::getModel('catalog/product')->getCollection;

// sta se desava sa kodom
class Mage_Catalog_Model_Product extends Mage_Core_Model_Abstract
{
  public function getCollection()
  {
    $collection
    = parent::getResourceCollection()->setStoreId($this->getStoreId());
    return $collection;
  }
}

// To gore je u sustini ovo:
$product = Mage::getModel('catalog/product');

// Ovde pozivamo collection (koji postoji i u varien obj)
$product->getCollection();

// Ovo je interno iz varien obj, poziva se uvek u getCollection()
// Znaci svaki poziv getCollection() generise i dodatni resource model
$prod_rm =Mage::getResourceModel('catalog/product');

// Shorthand za sve ono gore je:
// To preskace 3 koraka
$prod_col = Mage::getResourceModel('catalog/product_collection');

Methodi _setResourceModel, getResourceCollection se auto pozivaju prilikom
instanciranja modela.




### INSTANTIATION. SVI SLUCAJEVI *

// Mgge_Catalog_Model_Product
$model = Mage::getModel('catalog/product');
$model = Mage::getSingleton('catalog/product');

// Mage_Catalog_Model_Resource_Eav_Mysql4_Product
$resource = Mage::getResourceModel('catalog/product');
$resource = Mage::getResourcesSingleton('catalog/product');
$resource = Mage::getModel('catalog/resource_eav_mysql4_product');
$resource = $model->getResource();

// Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
$collection = Mage::getResourceModel('catalog/product_collection');
$collection = Mage::getResourceSingleton('catalog/product_collection');
$collection = Mage::getModel('catalog/resource_eav_mysql4_product_collection');
$collection = $model->getCOllection();



### RELATIONSHIPS MODEL/COLLECTION/RESOURCE MODEL

MODEL
* Instantiate items using Model's class name

COLLECTION
* Take connection adapters and primary Id fieldname

RESOURCE MODEL
* CRUD Operations

---

### Exercise. Categories

1. Echo the list of all stores(store groups)
  * Get list of all stores (Mage_Core_Model_Mysql4_Store_Collection
  * Get root category. ($store->getRootCategoryId())

2. Create a tree of all categories
  * Fetch all categories that dont have parents (use Category collection)
  * Load children by getChildren() of category obj
  * Load them by yourself using catalog_category_entity table



- Pravimo novi kontroler.
(Tu je objasnjen i php __call() kao magic method setters/getters..)

``
class Day_Two_ModelsControllers
  extends Mage_Core_Controller_Front_Action
{
  public function storesAction()
  {
    $stores = Mage::getResourceModel('core/store_collection');

    foreach( $stores as $store )
    {
      echo '<h2 style="color: red;">' . get_class($stores) . '</h2>';
      // dinamicki/magic methodi, getName, getCode pozivaju column name i code
      iz tabele
      echo '<h2>' . $store->getName() . '    ' . $store->getCode() . '</h2>';

      echo '<h2>' . $store->getRootCategoryId() . '</h2>';
    }
  }
}
``

- Get root category deo:
``
foreach ($stores as $store)
{
  $category = Mage::getModel('catalog/category')
                      ->load($store->getRootCategoryId());
  echo '<h2>' . $category->getName() . '</h2>';
}
``



> MAGICNI METHODI KOD GETNAME, GETCODE ...
>
> Mage_Core_Model_Abstract < Varien_Object
> Tu se nalazi __call($method, $args)
> Procedura:
> 1. Svaki put kad se izvrsi poziv neke methode magento poziva __call
> 2. On proverava kroz substr razlicite slucajeve (get,set,uns...)
> 3. U okviru svako slucaja se vrsi getData ili drugi prefix za ono sto ostaje
>    iza poziva, ukoliko ti podaci postoje u DB onda se vrsi poziv i vracaju
>    podaci.
>
> Primer: $obj->getSomeValue();
> substr = some_value
> nad some_value se vrsi provera u db, some_value postaje **KEY** u array(db)




---

- part 2. get category wiht no children
Nova akcija u ModelsController.php
``
public function categoriesAction()
{
  // Ukratko to je odgovarajuca tabela, trazene kategorija ima polje level=1
  $categories = Mage::getResourceModel('catalog/category_collection')
                        ->addFieldToFilter( 'level', 1 )
                        ->addAttributeToSelect('name'); // bez ovoga nemoze da
                        radi getName() ???

  // Razlog za 'name' je zbog toga sto su u pitanju EAV modeli,
  // da bi se ucitali odgovarajuci podaci mora da se koristi
  // addAttriuteToSelect('name')

  foreach( $category as $category )
  {
    echo '<h2>' . $category->getId() . '   ' .$category->getName() . '</h2>';
  }
}
``


- part 2. get children
``
..
  $categories = Mage::getResourceModel('catalog/category_collection')
                        ->addFieldToFilter( 'level', 1 );
  foreach( $category as $category )
  {
    $children =  $category->getChildren(); // vraca string sa , (comma)
    $childrenIds = explode(',' . $children); // od stringa pravi array

    foreach ($childrenIds as $child)
    {
      $child = Mage::getModel('catalog/category')->load($child);
      Zend_Debug::dump($child->debug());
    }
  }

``

---
---


### CRUD

Primer save/delete action za Modele.
Sve je slicno kao i sa ostalim framework: instancira se model, podesavaju polja
za unos u db, i na kraju save.

``
public function saveAction()
{
  $model = Mage::getModel('catalog/category');
  $model->setName('Moon');
  $model->setDecription('There is no honey on the moon!');
  $model->setIsActive(1);
  $model->save();
}
``
``
public function deleteAction()
{
  $model = Mage::getModel('catalog/category');
  $model->load(3);
  $model->delete();
}
``



### Varien_Object
Base klasa za vecinu Magento klasa. Omogucava koriscenje magic methoda.
(npr set-ovanje u saveAction)




### Data operation
Tok operacije:
1. Models
2. Resource Model
3. Varien/Data
4. Zend
5. Mysql



### Resource Model
Oni vrse load, delete, save podataka.
Ukratko oni rade sav CRUD za entity Modele.

Resource modeli su odgovorni _samo_ za **data access i manipulaciju**,
oni ne sadrze nikakvu business logic.



### Resource Model Adapter
Svaki RM sadrzi 2 adaptera za pristup podacima:
1. Read adapter
2. Write adapter



### Adapter
Ovde su objasnjene neke komanda adaptera, koje se koriste u ORM kod magenta.
1. Install/upgrade script: ``$this->run('...sql...')``
2. Resource model: ``$this->getRead/WriteAdapter()``
3. Public method:  ``$resource->getReadConnection()``
4. Any place:
   ``Mage::getSingleton('core/resource')->getConnection('default_read')``




### Mehanika Resource Modela


#### LOAD
1. **Mage_Core_Model_Mysql4_Abstract::load()**

Grafik na 1:27:30 prikazuje flowchart:
1. User loaduje neki id iz db
2. Poziva se load(id) iz Mage_Core_Model_Abstract
  2.1 ``_beforeLoad() - se izvrsava``
  2.2 load(model_entity, id) se poziva iz Mage_Core_Model_Mysql4_Abstract
  2.3 Mage_COre_Model_Mysql4_Abstract
    2.3.1 _getLoadSelected(id) se poziva
    2.3.2 query(select) >> db adapter
    2.3.3 setData(mixed,mixed) - VRACAJU se podaci iz db u entity model
    2.3.4 _afterLoad(model)
  2.4 _afterLoad()_

---

#### SAVE
Grafik na 1:29:09

Relativno je slicno, cirkulisu info izmedju modela i resource modela, postoje
before/after action methode, beginTransaction(), save(model), commit()...

#### DELETE
Kod na 1:29:14
Grafik na 1:29:20


---


### EVENTS THAT ARE FIRED
* Mage_Core_Model_Mysql4_Abstract
  1. _afterLoad(Mage_Core_Model_Abstract $object)
  2. _beforeSave(Mage_Core_Model_Abstract $object)
  3. _afterSave(Mage_Core_Model_Abstract $object)
  4. _beforeDelete(Mage_Core_Model_Abstract $object)
  4. _afterDelete(Mage_Core_Model_Abstract $object)




### Collection Load
load() izvrsava SQL i ucitava data **samo jednom**.
Pozivi ka load nakon prvog nece uticati na kolekciju.
Ovo spada u **Lazy Loading pattern**.

Najkorisniji/cesci primer je _addFieldToFilter()_:
``
// Varien_Data_Collection_Db
$stores = Mage::getModel('core/store')->getCollection();

$stores->addFieldToFilter('code', array('like' => 'uk_');

echo "Our collection has " . count($stores) . ' items(s)';
``
Ovde se vrsi jedan load poziv, a nakon toga se iz tog arraya filtrira ono sto
nam je neophodno.

**Prilikom prvog load() ucitavaju se kompletni podaci i sva polja**.

---

### Comparision Operators
Postoji 10-15 operatera za rad sa DB.
Video 1:35:25

addFieldToFilter se mapira na WHERE u sql:

npr: array("eq" => 'nesto') >> WHERE (m.code = 'nesto')

---

### Collection save
Loop kroz sve iteme kolekcije: (ovo magento radi interno)
``
foreach($this->_items as $items) {
  $item->save();
}
``


---

### Types of Storing Session
Ovo su vrste sesija u magentu, efektivno se koriste Db i memcached.

1. Default php session (ne koristi se)
2. Database
3. eaccelerator
4. memcached

### Session namespaces
Ovo su 4 grupe sessiona za razlicite delove sajta.
Njima se pristupa sa getSingleton():
1. Core
2. Checkout
3. Customer
4. Admin

primer: Mage::getSIngleton('core/session')

---


### Exercise

1. Create new module: Training_Animal

  * app/code/local/Training/Animal/etc/config.xml

2. Create:
  * Module registration file
  app/etc/modules/Training_Animal.xml
  ``
  <config>
    <modules>
      <Training_Animal/>
        <active>true</active>
        <codePool>local</codePool>
  ``

  * Necessary folders
  * Model folder
  app/code/local/Training/Animal/Model/Animal.php

  app/code/local/Training/Animal/Model/Mysql4/Animal/Collection.php
  app/code/local/Training/Animal/Model/Mysql4/Animal.php


  * Module configuration
  app/code/local/Training/Animal/etc/config.xml
  ``
  <global>
    <models>
      <training>
        <class>Training_Animal_Model</class>
        <resourceModel>training_animal_resource</resourceModel>
      </training>
      <traning_animal_resource>
        <clas>Training_Animal_Model_Mysql4</class>
        <entities>
          <animal><table>training_animal_entity</table></animal>
        <entities>
  ``

  * Model, Resource Model, COllection classes

  ``
  // Model
  // app/code/local/Training/Animal/Model/Animal.php
  class Training_Animal_Model_Animal
    extends Mage_Core_Model_Abstract
  {
    protected function _construct()
    {
      $this->_init('training/animal');
    }
  }
  ``

  ``
  // Resource Model
  // app/code/local/Training/Animal/Model/Mysql4/Animal.php
  class Training_Animal_Model_Mysql4_Animal
    extends Mage_Core_Model_Mysql4_Abstract
  {
    protected function _construct()
    {
      $this->_init('training/animal', 'entity_id');
    }
  }
  ``


  ``
  // Collection
  // app/code/local/Training/Animal/Model/Mysql4/Animal/Collection.php
  class Training_Animal_Model_Mysql4_Animal_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract
  {
    protected function _construct()
    {
      $this->_init('training/animal');
    }
  }
  ``


---
---


### Lesson 2. Magento DB Install. Install/upgrade scripts


* OVO JE NEPOTPUN FAJL. NAJBOLJE OVO UZETI IZ NEKOG TUTORIALA
ILI KNJIGE (PHP MAGENTO)


---





---
---

Section 6
---------

### Lesson 1. Overview



### Lesson 2. EAV Entity...



---


### Lesson 3. Attributes Management



ATTRIBUTES STRUCTURE
Ovo su sva bitna polja koja se cuvaju u DB vezana za atribute.
* attribute_id, entity_type_id
* attribute_code, attribute_model
* backend_model, backend_type, backend_table
* frontend_model, frontend_input, frontend_label, frontend_class
* is_required
* default_value



EAV CONFIG i ENTITY MODELS
???



EAV CONFIG EXAMPLES
* getAttribute($entityType, $attributeCode)
  > Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'price');

* getEntityType($entityTypeCode)



STANDARD ATTRIBUTE TYPES
* varchar
* text
* int
* decimal
* datetime



EAV SETUP
Klasa za setup:
* Mage_Eav_Model_Entity_Setup

* ona extenduje regularnu: Mage_Core_Model_Resource_Setup
  (koja sadrzi methode za manipulaciju atributima)



EAV: ADDATTRIBUTE
Primer:
``
$installer->addAttribute('catalog_product', 'test', array(
  'type' => 'varchar',
  'backend' => 'eav/entity_attribute_backend_array'
));

// update attribute
public function updateAttribute ($entityTypeId, $id, $field, $value=null,
$sortOrder=null)

> is_filterable
> Ovo je neka fora specificna koja ukazuje na razliku izmedju
> addattribute/updateattribute
> baciti detaljnije


EXAMPLE: ADD ATTRIBUTE TO PRODUCT
``
$installer = $this;

$installer->startSetup();

$data = array(
  'type' => 'varchar',
  'backend' => '',
  'frontend' => '',
  'label' => 'Test4',
  'input' => 'text',
  'class' => '',
  'source' => '',
  'user_defined' => false,
  'default' => '',
  'unique' => false,
  'visible_on_front' => true,
);

$installer->addAttribute('catalog_product', 'test_attribute', $data);
``



ATTRIBUTE MODELS
1. Backend Models
  * save/load/delete operation with attribute _value_

2. Source Models
  * select/multiselect attributes

3. Frontend
  * For rendering attribute on frontend



BACKEND MODELS
Lokacija: Mage_Eav_Model_Entity_Attribute (backend,frontend, source)
Koriste se za **transformisanje** podataka before/after save/load/delete.

POLJA:
* array
* datetime
* default
* increment
* serialized
* store
* time/created
* time/updated



INCREMENT ENTITIES
Backend increment auto assigned to 'increment_id' field of entity

Backend Increment entities:
* order
* invoice
* shipment
* credit memo
* customer



INCREMENT TABLE STRUCTURE
* eav_entity_store (to je tabela)
  1. entity_store_id
  2. entity_type_id
  3. store_id
  4. increment_prefix
  5. increment_last_id



FRONTEND MODEL
Nejasno je sta je hteo ovim da pokaze ???
Misli se na rendering proces, to je objasnjeno u primeru:
* catalog/view/attributes.phtml
  $attribute->getFrontend()->getValue($product)
* In database:  'var1, var2, ...'
* On frontend: Var1, Var2



SOURCE MODEL
On se odnosi na vrednosti u admin (ponudjene opcije):
* Table
  Select/multiselect attributes with options in db
* Config
  Select/multiselect attributes with options in config
* Boolean
  predifined options - Yes, No


---

EXERCISES

1. Create attribute from admin
  * default attribute_set
  * should appear on product edit page
  * is visible on view page

  Catalog>Attributes>Manage Attributes
    >> Add New Attribute
    - Attribute code: some_code
    - Scope: Store view
    - Input type: text field

  Catalog>Manage Attribute Sets
  Da bi taj atribut bio dostupan u nekom product, mora prvo da se
  doda preko Attribute set>Groups>Unassigned attribute

  Catalog>Manage Attribute
  Da bi on bio vidljiv u front end mora ovde da se podesi:
  Visible on Product view on front end: Yes



2. Create attribute from script
Mi smo ovde uradili multiselect attribute

``
// Training/Animal/sql/training_animal_setup/mysql4-upgrade-0.2.5-0.2.6.php
<?php
//$installer = $this; ovo ne vazi za training/animal

// Mage_Catalog_Model_Resource_Eav_Mysql4_Setup
// ovo je neophodno zbog toga sto je u animal/training module podesena
drugacija setup klasa
$installer = Mage::getResourceModel('catalog/setup', 'default_setup');

$installer->startSetup();

// addAttribute uses _prepareValues()
$data = array(
  'label'        => 'Script_Generated_MS_Option',
  'type'         => 'varchar', // multiselect uses comma sep storage
  'input'        => 'multiselect',
  'required'     => 0,
  'user_defined' => 1,
  'group'        => 'Prices',
  'option'       => array(
            'order' => array('one' => 1, 'two' => 2, 'three' => 3),
            'value' => array(
                  'one' => array(0 => 'Some Label One', 2 => 'Alt One'),
                  'two' => array(0 => 'Some Label Two', 2 => 'Alt Two'),
                  'three' => array(0 => 'Some Label Three', 2 => 'Alt Three'),
                  // 2 =>... je store id (npr english, german itd..)
              ),
    )
);

$installer->addAttribute('catalog_product', 'attribute_insalled', $data);

$installer->endSetup();

``
Ovoj skripti fali ispravan storage backend. (odradjeno u 0.2.7-0.2.8 upgrade)

MOZE SE PROVERITI DA LI POSTOJI U DB: EAV_ATTRIBUTE (table)

3. Update attribute from script
(Da bi radila skripta gornja mora backend_model)

``
// OVDE PODESAVAMO BACKEND
// sql/training_animal_setup/mysql4-upgrade-0.2.7-0.2.8.php
$installer = Mage::getResourceModel('catalog/setup', 'default_setup');

$installer->startSetup();

// ovo je bitan deo
$installer->updateAttribute(
    'catalog_product',
    'attribute_installed',
    'backend_model',
    'eav/entity_attribute_backend_array'
    );


$installer->endSetup();
``


``
// FRONTEND da bi se videlo
// sql/training_animal_setup/mysql4-upgrade-0.2.8-0.2.9.php
$installer = Mage::getResourceModel('catalog/setup', 'default_setup');

$installer->startSetup();

// ovo je bitan deo
$installer->updateAttribute(
    'catalog_product',
    'attribute_installed',
    'is_visible_on_front',
    1
    );

$installer->endSetup();
``


3. Create multiselect product attribute
4. Create multiselect product attribute from upgrade script
  Ovo je odradjeno u nasoj prvoj skripti


5. Customize its view
  * customize view of multiselect product from exerceize 3
  * show it as list instad of comma separted text
6. Create select attribute with pre-defined list of options

``
// /sql/training_animal_setup/mysql4-upgrade-0.2.9-0.2.9.1.php

$installer = Mage::getResourceModel('catalog/setup', 'default_setup');

$installer->startSetup();

$installer->updateAttribute(
    'catalog_product',
    'attribute_installed',
    'frontend_model',
    'training/entity_attribute_frontend_list' // moramo da napravimo
    );

$installer->updateAttribute(
    'catalog_product',
    'attribute_installed',
    'is_html_allowed_on_front' // da bi omogucio prikaz html a ne samo txt
    1
    );

$installer->endSetup();
``


Da bi to radilo mora da se napravi novi model, i da se overwriteuje getValue()
Training/ANimal/Model/Entity/Attribute/Frontend/List.php
``
<?php

class Training_Animal_Model_Entity_Attribute_Frontend_List
  extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
  public function getValue(Varien_Object $object)
  {
    // ovo uzima iz naseg prve skripte polje: 'input'
    if ($this->getConfigField('input') == 'multiselect') {

      $value = $object->getData($this->getAttribute()->getAttributeCode());

      $value = $this->geOption($value);

      if (is_array($value)) {
        $output = '<ul><li>'
        $output .= implode('</li><li>, $value);
        $output .= '</li></ul>'
        return $output;
      }

      return $value;
    }
    else {
      return parent::getValue($object);
    }
  }
}
``











---
---



Section 7
---------

---

### Lesson 1. Overview


ADMINHTML INIT WORKFLOW
* Mage::run()
* App starts
* admin router executes
* admin module is loaded by its router

``
# Primer za router (config.xml)
<admin>
  <routers>
    <adminhtml>
      <use>admin</use>
      <args>
        <module>Mage_Adminhtml</module>
        <frontName>admin</frontName>
      </args>
    </adminhtml>
  </routers>
</admin>
``


ADMIN STORE
To je global store (STORE ID = 0).
Ovde vidimo koji se event fireuje i kako se pokrece taj proces?

1. Mage_Adminhtml_Controller_action::dispatch()
2. Mage_adminhtml_Controller_Action::preDispatch()
  * fire event *adminhtml_controller_action_predispatch_start*
3. Adminhtml_Observer
  * Mage::app()->setCurrentStore('admin')


DIFFERENCE BETWEEN MODULES
Ovo videti detaljnije! odnosi se uglavnom na file structure

1. Adminhtml
2. Regular


ADMIN STRUCTURE
Spisak svih stvari iz menija:

1. Overview
  * List all Sections. Top items in menu. (not an action)

2. Dashboard
  * Shows some sales reports. Location:
  Controllers/DashboardController
  Model/Dashboard
  Block/Dashboard

3. Sales
  * Orders, invoices, shipments, credit memo items, Taxes

4. Catalog
  * Categories, Products, Attributes/attr sets

5. Mobile
  * Ovo je za mobile verziju magenta, manje bitno

6. Customer
  * Customer managment, Customer Groups, Customer Segments

7. Promo
  * Cupons, Cart rules...

8. CMS
  * CMS pages, block and widget management

9. Reports
  * Reports for Catalog, Sales modules

10. System
  * Utility: Users, stores, cache, System config (ovo je bitno)

11. Adminhtml action
  * Ovo je neka posebna akcija koja ima \_isAllowed() koji je security check
    (povezano sa ACL)


EXAMPLE ADMINHTML
Za ubacivanje naseg modula/ctrl u okviru odgovarajuceg admin space.
``
<admin>
  <routers>
    <adminhtml>
      <args>
        <modules>
          <widget before="Mage_Adminhtml">Mage_Widget_Adminhtml</widget>
        </modules>
      </args>
    </adminhtml>
  </routers>
</admin>
``


CACHING IN ADMIN
Ovo je vec znamo admin/system/cache managment.
Lokacija: var/cache



EXERCIZE: PAGE IN ADMIN, OBSERVER
1. Config.xml
Training/Animal je modul
``
<config>
...
<admin>
  <routers>
    <adminhtml>
      <args>
        <modules>
          <training after="Mage_Adminhtml">Training_Animal_Adminhtml</training>
        </modules>
      </args>
    </adminhtml>
  </routers>
</admin>
...
</config>
``

2. Controller za adminhtml
Training/Animal/controllers/Adminhtml/AnimalController.php
``
<?php
class Training_Animal_Adminhtml_AnimalController
  extends Mage_Adminhtml_Controller_Action
{
  public function indexAction() {
    // kod
  }
}
``

3. Layout info za admin u config.xml
``
<config>
...
<adminhtml>
  <layout>
    <updates>
      <training>
        <file>training/animal.xml</file>
      </training>
    </updates>
  </layout>
</adminhtml>
...
</config>
``

4. Layout za adminhtml (nije uradjeno u vezbi samo je prazan file)
design/default/default/layout/training/animal.xml

5. Pristupanje strani je na: site.com/admin/animal (index je default)
  Mislim da je route taj (a ne admin/training/animal) zbog toga sto smo ovo
  u configu postavili after Mage_Adminhtml dela

6. Dodavanje event observera koji loguje svaku visited page u file i radi samo
iz admina:

``
..
<adminhtml>
  ...
  <events>
    <controller_action_predispatch> -- ovo je prvi triggerovan prilikom inita
      <observers>
        <training_animal>
          <type>model</type>
          <class>training/observer</class>
          <method>controllerActionPredispatch</method>
        </training_animal>
      </observers>
    </controller_action_predispatch>
  </events>
  ...
</adminhtml>
``

7. Dodati observer
  Training/Animal/Model/Observer.php

``
class Training_Animal_Model_Observer
{
  public function controllerActionPredispatch(Varien_Event_Observer $observer)
  {
    $user = Mage::getSIngleton('admin/session')->getUser();

    if($user) {
      $name = $user->getUsername();
    } else {
      $name = '  NOT LOGGED IN!  ';
    }

    // Upisi svaki pristup nekog admina nekoj strani u log file
    Mage::log(
          $name . ' ' . Mage::app()->getRequest()->getPathInfo(),
          Zend_Log::INFO, 'admin.log', true
        );
  }
}
``


> INFO: SCOPE U CONFIG.XML
> Scope? u config.xml moze biti: global, admin, frontend
> Postoji jos adminhtml koji se odnosi na dizajn admin dela

> INFO: SECRET KEY
> Ovo je za admin deo generacija random key-a koji ide u svaki url.
> To je kao neka zastita (CSRF?)
> admin/system/admin/security/add secret key to URL


---

### Lesson 2. ACL Permissions

Magento panel sadrzi:
1. authentication system (username/password
2. ACL - system za Access Control Lists)

Authentication List
* _who_ can access your app
* User accounts, svaki sa svojim password

ACL Lists
* Which _parts_ of the system can _specific users_ access
* _Roles_ and _permissions_ for each system user
* Uses logical _names_ organized in tree like structure ?

---

MAGENTO ACCESS CONTROLLER - ROLES

Deo panela za podesavanje roles:
admin/system/permissions/roles
* add new role > Role Resources (lista modula)...


> NAPOMENA:
> NE DIRATI ADMIN ROLE!
> Zato sto kada se nesto promeni onda vise nece moci da se
> undo promena jer ni admin nece imati pristup
> Sve promene se obavljaju preko NEW ROLE

> NAPOMENA:
> Uvek prvo mora da se napravi role da bi mogao da se napravi user
> admin/system/permissions/users za kreiranje novih usera

---

APPYING MAGENTO ACL (isAllowed)

Svaki admin panel ctrl nasledjuje od Mage_Adminhtml_COntroller_Action.

U okviru njega postoji \_isAllowed() koja po defaultu vraca true.

To znaci da ukoliko NE definisemo nasu \_isAllowed() Admin panel ce biti
dostupan svim userima bez ikakve kontrole !!!

U ovom metodu trebaju da stoje sve ACL provere.

---

PRIMER - RESOURCE CHECK
Used to determine which Menu navigation items should be displayed to logged
user.
``
Mage/Adminhtml/Block/Page/Menu.php

protected function _checkAcl($resource)
{
  try {
    $res = Mage::getSingleton('admin/session')->isAllowed($resource);
  } catch (Exception $e) {
    return false;
  }
  return $res;
}

``

---

MENU ITEM DECLARATION

* NOVI NACIN: ADMINHTML.XML
``
<config>
  <menu>...</menu>
  <acl>
    ...
  </acl>
</config>
``

* Stari nacin: config.xml (DEPRECATED)
``
<adminhtml>
  <menu>...</menu>
  <acl>...</acl>
</adminhtml>
``

PRIMER MENU:
``
<config>
...
<menu>
  <catalog translate="title" module="catalog"> -- odnosi se na <title> tag
    <title>Catalog</title>
    <sort_order>30</sort_order>
    <depends>
      <module>Mage_Catalog</module>
    </depends>
    <children>
      <products translate="title" module="catalog">
        <title>Manage Products</title>
        <action>admintml/catalog_product</action> -- link za ctrl/action
        <sort_order>0</sort_order>
      </products>
    </children>
  </catalog>
</menu>
...
</config>
``

PRIMER ACL:
``
<config>
...
<acl>
  <resources>
    <admin>
      <children>
        <catalog translate="title" module="catalog"> - veza sa menu
          <title>Catalog</title>
          <sort_order>30</sort_order>
        </catalog>
      </children>
    </admin>
  </resources>
</acl>
...
</config>
``

---

ADMIN BACKEND MENU
Svaki link u admin panelu se odnosi na odredjeni MODULE.
Sales, Catalog, Customers, Promotions ....

---

ACL FOR SYSTEM CONFIGURATION
Ovo valjda prikazuje kako izgleda acl config za menu iteme u admin panelu.
``
<acl>
  <resources>
    <admin>
      <children>
        <config>
          <children>
            <catalog translate="title" module="catalog">
              <title>Catalog Section</title>
            </catalog>
          </children>
        </config>
      </children>
    </admin>
  </resources>
</acl>
``

---

EXAMPLE: CREATE ACL PERMISSIONS
Ovo kreira novi polje u Role Resource (New Role / Edit role meni)

I ovo omogucava da npr test useru ima pristup samo Catalog/Manage Animals/Whats
in my Zoo.

1. Kreiraj adminhtml.xml
Training/Animal/etc/adminhtml.xml
``
<config>
  <menu>
    <catalog>
      <children>
        <traning translate="title">
          <title>Manage Animals</title>
          <sort_order>40</sort_order>
          <children>
            <stalls translate="title">
              <title><![CDATA[What's in my Zoo]]</title>
              <sort_order>2</sort_order>
              <action>adminhtml/animal/index</action> -- route za menu item
            </stalls>
          </children>
        </traning>
      </children>
    </catalog>
  </menu>

  <!-- ODAVDE SE UVEK PONAVLJA ZA ACL -->
  <acl>
    <resources>
      <admin>
        <chilren>
  <!-- DO OVDE -->
          <catalog>
            <children>
              <!-- OVDE JE ISTO KAO I ZA MENU  -->
              <traning translate="title">
                <title>Animal PERMISSIONS</title>
                <sort_order>40</sort_order>
                <children>
                  <stalls translate="title">
                    <title><![CDATA[What's in my Zoo]]</title>
                    <sort_order>2</sort_order>
                    <action>adminhtml/animal/index</action> -- route za menu item
                  </stalls>
                </children>
              </traning>
              <!-- OVDE JE ISTO KAO I ZA MENU END -->
            </children>
          </catalog>
        </chilren>
      </admin>
    </resources>
  </acl>
</config>
``

---


### Lesson 3. System Configuration XML and Scope


SYSTEM CONFIGURATION

SYSTEM.XML
To je fajl slican adminhtml, ali on se, za razliku od adminhtml, odnosi 
iskljucivo na **System Configuration** deo u backend.


Sta sve postoji:
1. TABS: Empty container koji ne radi nista vec sadrzi Sections
2. SECTIONS: Konkretne opcije
  2.1 GROUPS: Ovo su razliciti meniji za neku sekciju (kao neki tabovi)
    2.1.1 FIELDS: Razlicita polja gde se vrsi unos ili izbor configuracionih
    opcija

KAKO OVO GORE IZGLEDA U SYSTEM.XML:
``
<config>
  <tabs>
    <!-- Tabs declaration -->
  </tabs>

  <sections>
    <!-- Section declaration -->

    <groups>
      <!-- Group declaration -->

      <fields>
        <!-- List of fields declaration -->
      </fields>

    </groups>
  </sections>
</config>
``

---

TABS DEFINITION
``
<tabs>
  <catalog translate="label" module="catalog">
    <label>Catalog</label>
    <sort_order>200</sort_order>
  </catalog>
</tabs>
``

SECTIONS DEFINITION
``
<sections>
  <catalog translate="label" module="catalog">
    <class>separator-top</class> -- css klasa
    <label>Catalog</label>
    <tab>catalog</tab> -- ovde se povezuje sa gornjim tabom <catalog>
    <frontend_type>text</frontend_type> -- vrsta itema
    <sort_order>40</sort_order>

    <show_in_default>1</show_in_default>
    <show_in_website>1</show_in_website>
    <show_in_store>1</show_in_store>
  </catalog>
</sections>
``

GROUPS DEFINITION
``
<!-- nalazi se uokviru SECTIONS -->
<groups>
  <frontend translate="label">
    <label>Frontend</label>
    <frontend_type>text</frontend_type>
    <sort_order>100</sort_order>

    <show_in_default>1</show_in_default>
    <show_in_website>1</show_in_website>
    <show_in_store>1</show_in_store>
  </frontend>
</groups>
``

FIELDS DEFINITION
``
<!-- nalazi se uokviru GROUPS -->
<fields>
  <list_mode translate="label">
    <label>List Mode</label>
    <frontend_type>select</frontend_type>

    <!-- Sourcemodel daje opcije za ovaj select u okviru donje klase -->
    <souce_model>adminhtml/system_config_source_catalog_listMode</souce_model>
    <sort_order>1</sort_order>

    <show_in_default>1</show_in_default>
    <show_in_website>1</show_in_website>
    <show_in_store>1</show_in_store>
  </list_mode>
</fields>
``

---

EXAMPLES

* Data location (**core_config_data** je naziv tabele)
  * Sadrzi sledeca polja:
    1. config_id
    2. scope (default, websites)
    3. scope_id (0 je default i odnosi se na global store)
    4. path (currency/options/base, to su nodovi iz nekog xml fajla,
       app/etc/config)
    5. value (USD)

* Fetching variable from system configuration
  - Mage::getStoreConfig(), Mage::getConfig()

* Adding an option to system configuration
  - Vezba donja


---

EXERCIZE: Create an option in sys config and output value in a form

1. Kreiraj Training/Animal/etc/system.xml
``
<config>
  <tabs>
    <training translate="label" module="training">
      <label>Training</label>
      <sort_order>500</sort_order>
    </training>
  </tabs>

  <sections>
    <training translate="label" module="training">
      <label>Animal</label>
      <sort_order>10</sort_order>
      <tab>training</tab> -- odnosi se na gornji nde

      <show_in_default>1</show_in_default>
      <show_in_website>1</show_in_website>
      <show_in_store>1</show_in_store>

      <groups>
        <general translate="label" module="training">
          <label>General Animal Settings</label>
          <sort_order>10</sort_order>

          <show_in_default>1</show_in_default>
          <show_in_website>1</show_in_website>
          <show_in_store>1</show_in_store>

          <fields>
            <recommendation translate="label comment"
            module="training">
              <label>Recommendation</label>
              <frontend_type>text</frontend_type>
              <sort_order>10</sort_order>

              <show_in_default>1</show_in_default>
              <show_in_website>1</show_in_website>
              <show_in_store>1</show_in_store>

              <depends>
                <show_recommendation>1</show_recommendation>
              </depends>
              <comments><![CDATA[<strong>This</strong> is a comment]]</comments>
            </recommendation>
            <show_recommendation translate="label"
            module="training">
              <label>Display recommendation</label>
              <frontend_type>select</frontend_type>

              <!-- SOURCE MODEL ODAVDE VUCE PODATKE -->
              <source_model>training/system_config_source_show</source_model>

              <sort_order>20</sort_order>

              <show_in_default>1</show_in_default>
              <show_in_website>1</show_in_website>
              <show_in_store>1</show_in_store>

              <tooltip>Wow! More JS PLS!</tooltip>
            </show_recommendation>
          </fields>
        </general>
      </groups>
    </training>
  </sections>
</config>
``

2. Dodaj Helper da bi radio ovaj xml (zbog translate ???)
Training/Animal/Helper/Data.php
``
class Training_Animal_Helper_Data
  extends Mage_COre_Helper_Abstract
{
  // prazan je fajl i mora da se definise i u config.xml
  // config>global>helper>class=Training_Animal_Helper
}
``

3. training/general/recommendation je path u db table gde se nalaze setovana
   opcija


---

### Lesson 4. Form and Grid Widgets



ADMINHTML_BLOCK_WIDGET
Ovo su pretpostavljam bitne komponente ove klase.
* Containers concept
* blockGroup variable
* controller variable
* Widget templates


BLOCKGROUP AND _CONTROLLER
```
protected function _prepareLayout() {
  $this->setChild('grid',
    $this->getLayout()->createBlock(
      $this->_blockGroup . '/' . $this->_controller . '_grid',
      $this->_controller . '.grid')->setSaveParametersInSession(true));

  return parent::_prepareLayout();
}
``


FORMS (Hijerarhija)
1. Adminhtml_Block_Widget_Form_Container
  * Used for wrapping
  * Ovo je klasa koja je najvisa u hijerarhiji

2. Adminhtml_Block_Widget_Form
  * Klasa iz magenta koja je odgovorna za forme

3. Varian_Data_Form
  * Generise i procesuira forme


FIELDSETS
To su containers za polja(fields)

Neke bitne methode:
* getChildrenHtml()
* getElementHtml()
* addField($elementid, $type, $config, $after=false) {}


FORM ELEMENTS
Velika kolicina predefinisanih field elementa.

Izlistani su na:
**lib/Varien/Data/FOrm/Element**

Npr: Checkbox.php, Date.php, FIle.php, Imagefile.php, Link.php, Note.php
Radio.php, REset.php, Textarea.php, Button.php, Radio.php, Select.php,
Text.php, Checkboxes.php, Label.php, Submit.php itd..


ADDFIELD()
``
public funciton addField($elementid, $type, $config, $after=false)
{
  if(isset($this->_types[$type])) {
    $className = $this->_types[$type];
  }
  else {
    $className = 'Varien_Data_Form_Element_' . ucfirst(strtolower($type));
  }

  $element = new $className($config);
  $element->setId($elementId);
  $this->addElement($element, $after);
  return $element;
}
``

---

EXAMPLE

Varien_Data_Form configuration:

``
// FORM HTML ELEMENT
$form = new Varien_Data_Form( array(
    'id'     => 'edit_form',
    'action' => $this->getData('action'),
    'method' => 'post'
));

// FORM>FIELDSET
// LEGEND to je neki uokviren naziv kao title za form
// fieldset je samo grupisanje form elemenata
// http://www.w3schools.com/tags/tag_legend.asp
$fieldset = $form->addFieldset('base_fieldset', array(
      'legend' => Mage::helper('training_admin')->__('Animal Information'),
      'class'  => 'fieldset-wide',
));

// Dodavanje polja za formu u okviru <fieldset></fieldset>
// Ovde dodajemo 'animal_id' polje
if($model-getId()) {
  $fieldset->addField('animal_id', 'hidden', array(
    'name'  => 'animal_id',
    'value' => $model->getId(),
  ));
}

// Dodavanje polja 'name'
$fieldset->addField('name', 'text', array(
    'name'     => 'name,
    'label'    => Mage::helper('training_admin')->__('Animal Name'),
    'title'    => Mage::helper('training_admin')->__('Animal Name'),
    'required' => true,
    'value'    => $model->getName(),
));
``

---

EXAMPLE: EDIT OBJECT

``
class Training_Animal_Block_Animal_Edit
  extends Mage_Adminhtml_Block_WIdget_FOrm_COntainer
{
  public function __construct(){
    // OVO SU BITNA GORENAVEDENA POLJA KOJE JE NEOPHODNO PODESITI!
    $this->_objectId = 'animal_id';
    $this->_blockGroup = 'training_admin';
    $this->_controller = 'animal_edit';

    parent::__construct();
  }
}

---

class Training_Animal_Block_Animal_Edit
  extends Mage_Adminhtml_Block_Widget_Form
{
  protected fucntion _prepareForm()
  {
    // Iz ovog modela uzimamo vrednosti za fields
    $model = $this->getModel();

    // Ovo kreira html element
    $form = new Varien_Data_Form(array(
      'id'     => 'edit_form',
      'action' => $this->getData('action'),
      'method' => 'post',
    ));
  }
}
``


STEPS TO CREATE A FORM
1. Create 2 actions for edit
2. Save a form
3. Create layout update
4. Setup Edit and Form class

EXAMPLE: LAYOUT UPDATE
``
<layout>
  <adminhtml_animal_list>
    <reference name="content">
      <block type="training_admin/animal_grid_container"
      name="animal_grid_container" />
    </reference>
  </adminhtml_animal_list>

  <adminhtml_animal_edit>
    <reference name="content">
      <block type="training_admin/animal_edit" name="training_admin_animal_edit"></block>
    </reference>
  </adminhtml_animal_edit>
</layout>
``

---

GRID ELEMENTS
1. Filters
2. Sorters
3. Data
4. Totals

ADMIN>MANAGE PRODUCTS>  (kako to izgleda)
* Filteri se nalaze na vrhu (tu se obicno unosi text)
* Sorteri su nazivi npr Name, Type i na njih se klikce za ascending/descending
* Data su sami podaci, kao polja u excel
* Totals - (sales orders) to su samo zbirovi nema ih na manage product


GRID WORKFLOW
1. Constructor
2. _prepareLayout
3. _toHtml
4. _beforeToHTml
  4.1 _prepareGrid
    4.1.1 _prepareColumns
    4.1.2 _prepareMassactionBlock
    4.1.3 _prepareCOllection

---

Ima objasnjenje poslednje tri methode iz _prepareGrid

---


GRID CONTAINER

``
class Training_Admin_Block_Animal_Grid_Container
  extends MAge_Adminhtml_Blcok_Widget_Grid_Containter
{
  public function __construct()
  {
    $action = Mage::app()->getRequest()->getActionName();
    $this->_blockGroup = 'training_admin';
    $this->_controller = 'animal';
    parent::__construct();
  }
}
``

---

GRID
1. Layout
2. 2 actions
3. Container
4. Grid object

EXERCIZE: Create grid and form

1. Kontroler
Training/ANimal/controllers/Adminhtml/AnimalController.php
``
class Training_Animal_Adminhtml_AnimalController
  extends Mage_Adminhtml_Controller_Action
{
  // INDEX REDIRECTUJE KA LISTACTION
  public function indexAction()
  {
    // module/ctrl/action
    $this->redirect('*/*/list');
  }


  // DISPLAY GRID
  public function listAction()
  {
    $this->_getSession()->setFormData(array());

    $this->_title($this->__('Catalog'))
          ->_title($this->__('Animal'));

    $this->loadLayout();

    $this->_setActiveMenu('catalog/training');
    $this->_addBreadcrumb($this->__('Catalog'), $this->__('Catalog'));
    $this->_addBreadcrumb($this->__('Animals'), $this->__('Animals'));

    $this->renderLayout();
  }


  // PROVERA ACL PERMISSIONS
  protected function \_isAllowed()
  {
    return Mage::getSingleton('admin/session')
                ->isAllowed('catalog/training');
  }


  // GRID ACTION FOR AJAX REQ
  public function gridAction()
  {
    $this->loadLayout()->renderLayout();
  }


  // OVO SE FORWARDUJE KA EDIT, TAMO OBAVLJAMO I EDIT I CREATE
  public function newAction()
  {
    // interni magento redirect
    $this->_forward('edit');
  }


  // CREATE or EDIT ANIMAL
  public function editAction()
  {
    // ucitavamo nas model, postavljamo vrednost registry, uzimamo id iz params
    $model = Mage::getModel('training/animal);
    Mage::register('current_animal', $model); // ovo daje instance of obj
    $id = $this->getRequest()->getParam('id');

    try {
      // Provera da li je moguce ucitati model sa tim id
      if($id) {
        if(! $model->load($id)->getId()) {
          Mage::throwException($this->__('No record with ID %s found.', $id));
        }
      }

      // Ukoliko postoji u db, onda podesi title
      // Ovde je grananje za new ili edit
      if ($model->getId()) {
        $pageTitle = $this->__('Edit %s (%s)', $model->getName(),
        $model->getType());
        } else {
          $pageTitle = $this->__('New Animal');
        }

      // Ovde se izvrsava update samog title HTML
      $this->_title($this->__('Catalog'))
           ->_title($this->__('Animals'))
           ->title($pageTitle);

      // Pripermi layout obj
      $this->loadLayout();

      // Meni, i breadcrumbs
      $this->_setActiveMenu('catalog/training');
      $this->_addBreadcrumb($this->__('Catalog'),
              $this->__('Catalog'));
      $this->_addBreadcrumb($this->__('Animals'),
              $this->__('Animals'));
      $this->_addBreadcrumb($pageTitle, $pageTitle);

      // Render na kraju
      $this->renderLayout();
    }
    // Hvata gresku iz try
    catch (Exception $e) {
      Mage::logException($e);
      $this->_getSession()->addError($e->getMessage());
      $this->_redirect('*/*/list');
    }
  }


  // Save, process form post
  public function saveAction()
  {
    // Proverava da li postoji post req
    if ($data = $this->getRequest()->getPost()) {
      // setup
      $this->_getSession()->setFormData($data);
      $model = Mage::getModel('training/animal');
      $id = $this->getRequest()->getParams('id');

      try {
        if($id) {
          $model->load($id);
        }

        // Ovde ucitavamo form data u model i save u db
        $model->addData($data);
        $model->save();


        // Session message, bice prikazan na redirect
        $this->_getSession()->addSuccess(
          $this->__('Animal was successfully saved.')
        );

        // Brise formdata
        $this->_getSession()->setFormData(false);

        // Ovo je za dugmad Save and continue, ili Save
        // U jednom slucaju redirect, u drugom ostaje na istoj strani (edit)
        if ($this->getRequest->getParam('back')) {
          $params = array('id' => $model->getId());
          $this->_redirect('*/*/edit', $params);
         } else {
           $this->_redirect(*/*/list);
         }
         } catch (Exception $e) {
           $this->_getSession()->addError($e->getMessage());

           // Ukoliko postoji model i greska ovaj redirect sa params
           if ($model && $model->getId()) {
             $this->_redirect('*/*/edit', array(
              'id' => $model-getId()
              ));
              } else {
                // Ukoliko nema modela onda ga redirect na create new
                $this->_redirect('*/*/new');
              }
         }

         // Kraj
         return;
    }

    // Ukoliko nema post req
    $this->_getSession()->addError($this->__('No data found to save'));
    $this->_redirect('*/*'); //index
  }


  // DELETE ANIMAL ENTITY
  public function deleteAction()
  {
    // setup
    $model = Mage::getModel('training/animal');
    $id = $this->getRequest()->getParams('id');

    try {
      if($id)
      {
        if (! $model->load($id)->getId())
        {
          Mage::throwException(
            $this->__('No record with ID %s found.', $id)
          );
        }

        // Delete model, sacuvaj ime za kasniju upotrebu
        $name = $model->getName();
        $model->delete();

        // Dodaj session message uspesno, i redirect
        $this->_getSession()->addSuccess(
          $this->__('%s (ID %d) was successfully deleted', $name, $id)
        );
        $this->_redirect('*/*');

      }
    } catch (Exception $e)
    {
      // Error msg, redirect
      Mage::logException($e);
      $this->_getSession()->addError($e->getMessage());
      $this->_redirect('*/*');
    }
  }

}


``

2. Layout admin
design/adminhtml/default/default/layout/training/animal.xml
``
<layout>
  <adminhtml_animal_list>
    <reference name="content">
      <block type="training/adminhtml_animal" name="training.animal.list" />
    </reference>
  </adminhtml_animal_list>

  <!-- AJAX grid action -->
  <adminhtml_animal_grid>
    <remove name="root" /> <!-- zato sto hocemo samo da prikazemo deo grid -->
    <block type="training/adminhtml_animal_grid"
           name="training.animal.grid"
           output="toHtml" />
  </adminhtml_animal_grid>

  <adminhtml_animal_edit>
    <reference name="content">
      <block type="trianing/adminhtml_animal_edit"
             name="training.animal.form" />
    </reference>
    <refenrece name="left">
      <block type="trianing/adminhtml_animal_edit_tabs"
             name="training.animal.tabs" />
    </refenrece>
  </adminhtml_animal_edit>

</layout>
``

3. Blocks
Training/Animal/Block/Adminhtml/Animal/
/Edit/Edit.php
/Edit/Grid.php
Animal.php

``
// Animal.php block koji je setup grid CONTAINER
class Training Animal_Block_Adminhtml_Animal
  extends MAge_Adminhtml_Block_Widget_Grid_Container
  {
    // Initialize grid container settings
    //
    // Ime koje se generise za koriscenje u layout.xml
    // Poziva se za list
    //
    // Child grid block class will be:
    // $this->_blockGroup . '/' . $this->_controller . '_grid'
    // >> training/adminhtml_animal_grid
    //
    // Ovo se generise zahvaljujuci _prepareLayout()
    // tu postoji setChild()

    protected function _construct()
    {
      $this->_blockGroup = 'training';
      $this->_controller = 'adminhtml_animal';

      //$this->_headerText = Mage::helper('traing')->__('List Animals');
      $this->_headerText = $this->__('List Animals'); // ovo je sad pravilno

      parent:;_construct();
    }

  }
``

Edit/Grid.php
``
class Training_animal_Block_Adminhtml_animal_Grid
  extends Mage_Adminhtml_Block_Wiget_Grid
{
  // init grid settings
  protected function \_construct()
  {
    parent::_construct();

    // Podesavanja
    $this->setId('training_animal_list');
    $this->setDefaultSOrt('id');

    // Override method getGridUrl() zbog ajax
    $this->setUseAjax(true);
  }


  // Prepare animal collection
  protected function \_prepareCollection()
  {
    $collection = Mage::getResourceModel('training/animal_colelction');
    $this->setCollection($collection);

    return parent::_prepareCollection();
  }


  // Prepare grid columns
  protected function \_prepareColumns()
  {
    $this->addColumn('id', array(
      'header'   => $this->__('ID'),
      'sortable' => true,
      'width'    => '60px',
      'index'    => 'entity_id'
    ));

    $this->addColumn('type', array(
      'header'   => $this->__('Animal Type'),
      'index'    => 'type'
    ));
kj
    $this->addColumn('name', array(
      'header'   => $this->__('Name'),
      'index'    => 'name',
      'column_has_class' => 'name'
    ));

    $this->addColumn('ediblee', array(
      'header'   => $this->__('Is Edible'),
      'width'    => '100px',
      'index'    => 'edible',
      'type'     => 'options,'
      'options'  => Mage::getModel('training/entity_attribute_source_maybe')
                      ->getOptionsArray()
                // options => array(0 => 'No', 1=> 'Yes', 2 => 'Maybe')
    ));

    $this->addColumn('action', array(
      'header'   => $this->__('Action'),
      'width'    => '100px',
      'type'    => 'action',
      'getter'    => 'getId',
      'actions' => array(
        // ovo se prosledjuje u getter (getId)
        array(
              'caption' => $this->__('Edit'),
              'url'     => array('base' => '*/*/edit'),
              'field'   => 'id',
          ),
        ),
        'filter' => false,
        'sortable' => false,
    ));


    return parent::_prepareColumns();
  }


  // URL gde saljemo korisnika koji clickne na neki row
  // Ovo je auto povezano sa JS
  public function getRowUrl($row)
  {
    return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }


  // Grid url za ajax
  // obavezno mora da se definise za ajax
  public function getGridUrl()
  {
    // nije objasnjeno cemu current array
    return $this->getUrl('*/*/grid', array('_current' => true));
  }
}

``

Edit/Edit.php

``
class Training_Animal_Block_Adminhtml_Animal_Edit
  extends Mage_Admihtml_Block_Widget_Form_Container
  {
    // outer form wrapper
    protected function \_construct()
    {
      parent::_construct();

      $this->_objectId = 'id';
      $this->_blockGroup = 'training';
      $this->_controller = 'adminhtml_animal';
      $this->_mode = 'edit';

    }


    protected fucntion \_prepareLayout()
    {
      parent::_prepareLayout();

      // Podesavanje buttons, edit
      $this->_updateButton('Save', 'label',
              $this->__('Save animal'));

      $this->_updateButton('delete', 'label',
              $this->__('Delete animal'));

      // Dodavanje button
      $this->_addButton('save_and_continue', array(
                'label' => $this->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class' => 'save',
      ), -100);

      $this->_formScripts[] = '
      function saveAndContinueEdit() {
        editForm.submit($('edit_form').action = 'back/edit/');
      }
      ';

      return $this;
    }


    // Return title string to show above the form
    public function getHeaderText()
    {
      // podeseno u ctrl
      $model = Mage::registry('current_animal');

      // ukoliko postoji db record
      if($model && $model->getId()) {
        return $this->__('Edit Animal %s (%s)',
          $this->htmlEscape($model->getName()),
          $this->htmlEscape($model->getType()),
        );
      } else {
        // ako nema db record
        return $this->__('New animal');
      }
    }
  }

``


/Edit/Form.php

``
class Training_Animal_Block_Adminhtml_Animal_edit_Form
  extends Mage_Adminhtml_Block_Widget_Form
{
  // inner form wrapper?
  protected function \_prepareForm()
  {
    // vezano za post iz forme
    $form = new Varien_Data_Form(array(
        'id' => 'edit_form',
        'action' => $this->getUrl('*/*/save',
                    array( 'id' => $this->getRequest()->getParam('id') )),
        'method' => 'post',
        'enctype' => 'multipart/form-data',
    ));

    $form->setUseContainer(true);
    $this->setForm($form);

    return parent::_prepareForm();
  }
}
``

/Edit/Tab/General.php
``
class Training_Animal_Block_Adminhtml_Animal_Edit_Tab_General
  extends Mage_adminhtml_Block_Widget_FOrm
  {
    protected function \_prepareFOrm()
    {
      $form = new Varien_Data_Form();
      $form->setHtmlIdPrefix('general');
      $fieldset = $form->addFieldset('general_form', array(
            'legend' => $this->__('General Setup')
      ));

      if(Mage::registry('current_animal')->getId()) {
        $fieldset->addField('entity_id', 'label', array(
            'label' => $this->__('Entity ID: %s',
                          Mage::registry('current_animal')->getId()
        ))
        );
      }


      // EAV ENTITIEES
      // $this->_setFieldset($attributes, $fieldset, $exclude)

      $fieldset->addField('name', 'text' array(
        'label' => $this->__('Name'),
        'class' => 'required-entry',
        'required' => true,
        'name' => 'name',
      ));

      $fieldset->addField('type', 'text' array(
        'label' => $this->__('Animal Type'),
        'class' => 'required-entry',
        'required' => true,
        'name' => 'type',
      ));

      $fieldset->addField('edible', 'select' array(
        'label' => $this->__('is Edible'),
        'class' => 'required-entry',
        'required' => true,
        'name' => 'edible',
        'values' => array('No', 'Yes', 'Maybe')
          // ili: Mage::getModel('traiing/entity_attribute_source_maybe')
                      // ->getOptionsArray()
      ));


      // zavrseno podesavanje
      $form->addValues($this->_getFOrmData());
      $this->setForm($form);
    }
  }
