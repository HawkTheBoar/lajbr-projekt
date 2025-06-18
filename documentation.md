# Dokumentace rout v Laravel aplikaci

## Klientské rozhraní
- `/` -> Přesměruje na hlavní stránku katalogu.
- `/catalogue` -> Zobrazí hlavní stránku katalogu.
- `/catalogue/category/{category}` -> Zobrazí produkty v dané kategorii.
- `/catalogue/product/{product}` -> Zobrazí detail produktu.

## Autentizace
- `/auth/login` -> Zobrazí přihlašovací formulář (GET).
- `/auth/login` -> Zpracuje přihlašovací data (POST).

## Administrace
- `/admin/login` -> Zobrazí přihlašovací formulář pro admina.
- `/admin/login` -> Zpracuje přihlašovací data admina (POST).
- `/admin/logout` -> Odhlásí admina.
- `/admin/dashboard` -> Zobrazí admin dashboard (chráněno middlewarem).
- `/admin` -> Přesměruje na admin dashboard (chráněno middlewarem).
- `/admin/products` -> CRUD operace pro produkty (chráněno middlewarem).
- `/admin/categories` -> CRUD operace pro kategorie (chráněno middlewarem).

## Košík
- `/cart` -> Zobrazí obsah košíku.
- `/cart/add` -> Přidá produkt do košíku.
- `/cart/remove` -> Odebere produkt z košíku.
- `/cart/empty` -> Vyprázdní celý košík.
- `/cart/checkout` -> Zobrazí stránku po dokončení objednávky.

# Dokumentace Route metod v Laravel

## Základní routovací metody

1. **`Route::get($uri, $callback)`**  
   - Definuje GET routu
   - Používá se pro zobrazení stránek
   - Příklad: `Route::get('/about', fn() => view('about'))`

2. **`Route::post($uri, $callback)`**  
   - Definuje POST routu
   - Používá se pro zpracování formulářů
   - Příklad: `Route::post('/contact', [ContactController::class, 'store'])`

3. **`Route::prefix($prefix)`**  
   - Přidá předponu ke všem routám ve skupině
   - Snižuje duplicitu v URL
   - Příklad: `Route::prefix('admin')->group(...)`

4. **`Route::name($name)`**  
   - Přiřadí jmenný prefix routám
   - Umožňuje generovat URL pomocí `route()`
   - Příklad: `Route::name('admin.')->group(...)`

5. **`Route::group($options, $callback)`**  
   - Seskupí routy se společnými vlastnostmi
   - Může kombinovat prefixy, middleware apod.
   - Příklad: `Route::group(['middleware' => 'auth'], ...)`

## Pokročilé routovací metody

6. **`Route::resource($name, $controller)`**  
   - Automaticky generuje CRUD routy pro controller
   - Vytvoří těchto 7 standardních rout:
     - GET `/resource` -> index()
     - GET `/resource/create` -> create()
     - POST `/resource` -> store()
     - GET `/resource/{id}` -> show()
     - GET `/resource/{id}/edit` -> edit()
     - PUT/PATCH `/resource/{id}` -> update()
     - DELETE `/resource/{id}` -> destroy()
   - Příklad: `Route::resource('products', ProductController::class)`

7. **`Route::middleware($middleware)`**  
   - Aplikuje middleware na routu/skupinu
   - Může být řetězec nebo pole middleware
   - Příklad: `Route::middleware('auth:admin')->group(...)`

## Jak vytvořit controller pro Route::resource

1. Vytvořte controller pomocí Artisanu:
```bash
php artisan make:controller ProductController --resource
```
```php
class ProductController extends Controller
{
    public function index() {}      // Zobrazí seznam
    public function create() {}    // Zobrazí formulář pro vytvoření
    public function store() {}     // Uloží nový záznam (POST)
    public function show() {}      // Zobrazí detail
    public function edit() {}      // Zobrazí formulář pro editaci
    public function update() {}    // Aktualizuje záznam (PUT/PATCH)
    public function destroy() {}   // Smaže záznam (DELETE)
}
```
# Dokumentace autentizace v administraci

## Autentizační systém

### 1. Admin Model (Admin.php)
Rozšiřuje Authenticatable pro správu přihlašování. Obsahuje:
- $fillable - povolené atributy pro hromadné přiřazení
- $hidden - atributy skryté při serializaci (heslo)
Ukládá základní údaje admina: jméno, email a heslo.

### 2. LoginController
Hlavní metody:
- index() - Zobrazí přihlašovací formulář
- login() - Zpracuje přihlašovací údaje:
  * Validuje email a heslo
  * Používá guard 'admin' pro oddělení od běžných uživatelů
  * Při neúspěchu vrátí chybu
- logout() - Odhlásí admina:
  * Zruší session
  * Vygeneruje nový CSRF token

### 3. AdminRedirect Middleware
Hlavní funkce:
- Chrání admin routy před nepřihlášenými uživateli
- Kontroluje pomocí Auth::guard('admin')->check()
- Při neúspěchu přesměruje na /admin/login

### 4. Konfigurace (auth.php)
Definuje:
- Speciální guard 'admin':
  * Používá 'session' driver
  * Odkazuje na provider 'admins'
- Provider 'admins':
  * Používá Admin model
  * Oddělený od běžných uživatelů

## Artisan příkaz admin:create

POPIS FUNKCE:
Interaktivní vytvoření admin účtu přes CLI s validací vstupů.

POUŽITÍ:
php artisan admin:create

PRŮBĚH:
1. Vyžádá si:
   - Jméno admina
   - Email (musí být unikátní)
   - Heslo (min. 8 znaků)
   - Potvrzení hesla
2. Provede validaci:
   - Kontrola unikátnosti emailu
   - Shoda hesel
   - Délka hesla
3. Vytvoří admina:
   - Heslo se ukládá zahashované
   - Vrátí potvrzení o úspěchu

VÝHODY:
- Rychlé vytvoření adminů bez GUI
- Bezpečné zadání hesla (neechoované)
- Automatická validace
# Dokumentace třídy CartService

## Účel třídy
CartService slouží ke správě nákupního košíku uživatele. Ukládá položky v session a poskytuje metody pro manipulaci s obsahem košíku.

## Hlavní metody

### getStoredProducts()
- Vrací všechny produkty v košíku
- Vrací pole ve formátu [ ['productId' => X, 'quantity' => Y], ... ]
- Pokud je košík prázdný, vrací prázdné pole

### addItem($productId, $quantity = 1)
- Přidá produkt do košíku
- Pokud produkt již v košíku je, zvýší jeho množství
- Parametry:
  - $productId: ID produktu
  - $quantity: množství (výchozí 1)

### removeItem($productId, $quantity = 1)
- Sníží množství produktu v košíku
- Pokud množství klesne na 0 nebo méně, produkt odstraní
- Parametry stejné jako u addItem

### emptyCart()
- Úplně vyprázdní celý košík
- Odstraní všechny položky ze session

### totalItems()
- Spočítá celkový počet položek v košíku
- Vrací součet všech množství jednotlivých produktů

## Příklad použití
$cartService = new CartService();

// Přidání produktů
$cartService->addItem(1, 2); // produkt ID 1, množství 2
$cartService->addItem(3);    // produkt ID 3, výchozí množství 1

// Odebrání produktu
$cartService->removeItem(1, 1); // sníží množství produktu 1 o 1

// Získání obsahu košíku
$items = $cartService->getStoredProducts();

// Vyprázdnění košíku
$cartService->emptyCart();

# Dokumentace Eloquent modelů

## Základní vytvoření modelu

Pro vytvoření základního Eloquent modelu:
1. Vytvořte třídu rozšiřující Model
2. Definujte $fillable pro hromadné přiřazení
3. Definujte vztahy pomocí metod

Příklad:
php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['name', 'price'];
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
}

## Dokumentace modelů

### Admin
- Autentizační model pro administrátory
- Rozšiřuje Authenticatable
- Vlastnosti:
  - $fillable: name, email, password
  - $hidden: password, remember_token

### Category
- Model pro kategorie produktů
- Podporuje stromovou strukturu (parent/children)
- Vztahy:
  - children(): HasMany - podkategorie
  - parent(): BelongsTo - nadřazená kategorie
  - products(): HasMany - produkty v kategorii

### Product
- Model pro produkty
- Vlastnosti:
  - $fillable: title, image_uri, description, category_id, price
- Vztahy:
  - category(): BelongsTo - přiřazená kategorie

### User
- Model pro běžné uživatele
- Rozšiřuje Authenticatable
- Vlastnosti:
  - $fillable: name, email, password
  - $hidden: password, remember_token
  - $casts: automatické přetypování atributů

## Základní Eloquent operace
php
// Vytvoření
Product::create(['name' => 'Produkt', 'price' => 100]);

// Čtení
$product = Product::find(1);
$products = Product::where('price', '>', 50)->get();

// Aktualizace
$product->update(['price' => 120]);

// Smazání
$product->delete();

# Výhody a nevýhody Laravel frameworku

## Výhody
1. RYCHLÝ VÝVOJ
- Hotové komponenty (autentizace, routování, ORM)
- Artisan CLI pro automatizaci úkolů
- Blade šablonovací systém

2. DOKUMENTACE A KOMUNITA
- Výborná oficiální dokumentace
- Velká aktivní komunita
- Mnoho tutoriálů a balíčků

3. BEZPEČNOST
- Zabudované ochrany proti SQL injection, XSS, CSRF
- Automatické hashování hesel
- Ověřování uživatelů

## Nevýhody

1. VÝKON
- Pomalejší než čisté PHP
- Vyšší nároky na paměť
- Nutnost optimalizace pro vysokou zátěž

2. ZÁVISLOST
- Omezená flexibilita v některých případech
- Nutnost dodržovat konvence frameworku

4. AKTUALIZACE
- Časté aktualizace vyžadují údržbu
- Zpětná kompatibilita není vždy garantovaná
- Nutnost sledovat změny mezi verzemi

## Závěr
Laravel výrazně urychluje vývoj webových aplikací a poskytuje robustní bezpečnostní funkce, za cenu mírného snížení výkonu a nutnosti naučit se jeho konvence. Je výbornou volbou pro střední až velké projekty a týmy. Pro jednodušší weby bych asi zvolil jiné řešení.
