// libraries to use for roles and permissions

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

$role = Role::create(['name' => 'student']);
$role = Role::create(['name' => 'admin']);

$permission = Permission::create(['name' => 'edit_books']);
$permission = Permission::create(['name' => 'show_books']);
$permission = Permission::create(['name' => 'add_books']);
$permission = Permission::create(['name' => 'delete_books']);

$role = Role::find(2);
$role->givePermissionTo(['edit_books', 'show_books', 'add_books', 'delete_books']);
$role = Role::find(1);
$role->givePermissionTo(['show_books']);

$user->assignRole('admin');
<!-- $book = factory(App\Book::class)->create(); -->

