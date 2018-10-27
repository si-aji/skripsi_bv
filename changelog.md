-11 Oct 2018
```
- Add Email Verification by [Bestmomo](https://github.com/bestmomo/laravel-email-confirmation)
- Add AdminLTE 2 (Alpha v2) by [AdminLTE.io](https://adminlte.io/themes/dev/AdminLTE/)
- Add new SweetAlert by [t4t5](https://sweetalert.js.org/guides/)
```

-26 Oct 2018 (v.0.1.0)
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

-27 Oct 2018 (v.0.2.0)
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
