- 4 Nov 201 (v.0.6.0)
```
- [Module] Add migration for Toko
- [Module] Add model for Toko
- [Module] Add controller for Toko
- [Module] Add controller for User(Karyawan)
- [Plugins] Add tooltip init on template so it can be used globally in front/back end
- Modify guest (RedirectIfAuthenticated) middleware redirect from /home to /staff
- Modify (add) exception for confirmation and resend in RegisterController (Traits)
- Modify user migration so email can be null
- Modify dashboard (show alert for add an email/verify an email)

*Need to do
- Add profile
    + User cannot see their own data on karyawan
    + User only can modify their email, pass on profile
    + User cannot modify other user email, username or pass
- Forget Password
    + Remove username, so to change password after click on link, user only put new password and everything is done
```
-------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------
- 2 Nov 2018 (v.0.5.0)
```
- [Module] Add migration for Kostumer
- [Module] Add model for Kostumer
- [Module] Add controller for Kostumer
- [Module] Add Kostumer modele
    + Insert (Fix)
    + Update (Fix)
    + Delete (Menunggu transaksi [Cek apakah terdapat transaksi dengan kostumer terkait, jika ada maka tidak bisa dihapus])
- [Module] Add migration for Supplier
- [Module] Add model for Supplier
- [Module] Add controller for Supplier
- [Module] Add Kostumer modele
    + Insert (Fix)
    + Update (Fix)
    + Delete (Fix [Change supplier_status from Aktif to Tidak Aktif])
- [Module] Change textarea to CKEDITOR 5 on Barang module
- [Plugins] Change ckeditor asset to CKEDITOR 4
- [Plugins] Change ckeditor plugins to CKEDITOR 5 cdn
- [Asset] Add unscapehtml function on sa_bv.js
```
-------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------
- 1 Nov 2018 (v.0.4.0)
```
- Add migration for barang module
- Add model for barang module
    + set relation with kategori model
- [Plugins] Modified select2.css
- [Asset] Modified bootstrap.bundle.js
- [Asset] Modified adminlte.css (modal)
- [Module] Add relation to Kategori model
- [Module] Add other json format to Kategori controller
- [Functions] Add IDR Currency format (helper)
- [Functions] Add IDR Currency format (sa_bv.js)
- 
```
-------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------
- 27 Oct 2018 (v.0.3.0)
```
- [Plugins] Add DataTable
- [Module] Add Kategori Module
    + Migration (Fix)
    + Model (Fix)
    + Controller (Fix)
    + Insert (Fix)
    + Update (Fix)
    + Delete (Fix)
- [Asset] Change static navbar to fixed top navbar
- Add middleware for all backend module
- Change structure for sa_bv, notify, animate, etc to template instead of each module
```
-------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------
- 27 Oct 2018 (v.0.2.0)
```
- [Asset] Add swal function to sa_bv.js
- [Plugins] Change sweetalert from cdn to local
- Add field function on Illuminate\Foundation\Auth to determine request field is email / username
- Add line of code to save email_verified_at on Bestmomo/Traits/RegisterController@confirm
- Add Helper for global function
- Add files for autoload helper on composer.json
- Fix actionURL on Illuminate\Notifications\resource\views\email.blade.php on line 57 (change actionUrl to actionURL)
- Change credentials on Illuminate\Foundation\Auth to match request field
- Change return to json format from Bestmomo/Traits/LoginController
- Change return to json format from Resend at Bestmomo/Traits/RegisterController
- Change url to function for (Again) resend link from Bestmomo/publishable/translations/en/confirmation.php
- Change login response at Bestmomo\LaravelEmailConfirmation\Traits line 49
- Change return to json format from Illuminate\Foundation\Auth@logout
```
-------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------
- 26 Oct 2018 (v.0.1.0)
```
- [Database] Add username to users table
- [Plugins] Add animate.css
- [Plugins] Add Bootstrap notify
- [Asset] Add Ajax loading effect
- [Asset] Add sa_bv for custom css
- [Asset] Add sa_bv for custom js
- [Asset] Add notify custom style
- Add username to User model
- Add username to validator and create at RegisterController
- Change default register page to custom
- Change return to json format from Bestmomo/Traits/RegisterController
```
-------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------
- 11 Oct 2018
```
- Add Email Verification by [Bestmomo](https://github.com/bestmomo/laravel-email-confirmation)
- Add AdminLTE 2 (Alpha v2) by [AdminLTE.io](https://adminlte.io/themes/dev/AdminLTE/)
- Add new SweetAlert by [t4t5](https://sweetalert.js.org/guides/)
```
-------------------------------------------------------------------------------------
