<?php

return [
    // Navigation
    'home' => 'Strona główna',
    'login' => 'Zaloguj się',
    'register' => 'Zarejestruj się',
    'logout' => 'Wyloguj się',
    'management_content' => 'Zarządzanie treściami',

    'opinions' => 'Opinie',
    'faqs' => 'FAQs',
    'about_me' => 'O mnie',
    'products' => 'Produkty',
    'translations' => 'Tłumaczenia',
    'translation' => 'Tłumaczenie',
    'translation_exists' => 'Tłumaczenie dla danego języka już istnieje.',
    'validation_failed' => 'Walidacja nie powiodła się.',

    // Auth
    'name' => 'Imię',
    'email' => 'Email',
    'password' => 'Hasło',
    'forgot_password' => 'Zapomniałeś hasła?',
    'reset_password' => 'Resetuj hasło',
    'remember_me' => 'Zapamiętaj mnie',
    'password_confirmation' => 'Potwierdź hasło',
    'please_confirm_your_password' => 'Proszę potwierdź swoje hasło przed kontynuowaniem.',
    'send_password_reset_link' => 'Wyślij link do resetowania hasła',
    'section_auth_bg_alt' => 'Zdjęcie tła sekcji autoryzacji do panelu administracyjnego',

    // Verification
    'verify_email' => 'Zweryfikuj adres e-mail',
    'verification_link_sent' => 'Nowy link weryfikacyjny został wysłany na Twój adres e-mail.',
    'check_email_for_verification' => 'Przed kontynuowaniem sprawdź swoją skrzynkę e-mail w poszukiwaniu linku weryfikacyjnego.',
    'did_not_receive_email' => 'Jeśli nie otrzymałeś e-maila',
    'click_here_to_request_another' => 'kliknij tutaj, aby poprosić o inny',

    // Meta titles
    'title_meta_login' => 'Logowanie - Admin Panel',
    'title_meta_register' => 'Rejestracja - Panel Administracyjny',
    'title_meta_verify_email' => 'Weryfikacja Email - Panel Administracyjny',
    'title_meta_confirm' => 'Potwierdź Hasło - Panel Administracyjny',
    'title_meta_email' => 'Email - Panel Administracyjny',
    'title_meta_reset' => 'Resetuj Hasło - Panel Administracyjny',
    'title_meta_home' => 'Strona Główna - Panel Administracyjny',
    'title_meta_opinion' => 'Opinie - Panel Administracyjny',
    'title_meta_about' => 'O mnie - Panel Administracyjny',

    // Tables - Titles
    'table_button_add' => 'Dodaj :item',
    'table_button_edit' => 'Edytuj',
    'table_button_delete' => 'Usuń',
    'table_button_view' => 'Zobacz',

    // Modals - Titles
    'modal_button_save' => 'Zapisz',
    'modal_button_cancel' => 'Anuluj',
    'modal_button_delete' => 'Usuń',

    // Deletion
    'confirm_delete_title' => 'Potwierdź usunięcie',
    'confirm_delete_content' => 'Czy na pewno chcesz usunąć?',
    'delete_success' => 'Element został usunięty pomyślnie.',
    'delete_failed' => 'Usuwanie nie powiodło się.',
    'error_relation_mismatch' => 'Błąd: niepoprawne powiązanie.',
    'error_bad_url' => 'Błąd: niepoprawny adres URL.',
    'deleted' => 'Usunięto.',
    'deleting' => 'Usuwanie...',

    'users_logins_table_title' => 'Użytkownicy i Ostatnie logowania',
    'users_logins_table_subtitle' => 'Zobacz ostatnie logowania użytkowników',

    // Opinions
    'opinions_table_title' => 'Opinie',
    'opinions_table_subtitle' => 'Zarządzaj opiniami na stronie',
    'opinions_add_opinion' => 'Dodaj nową opinię',
    'opinions_add_translation' => 'Dodaj tłumaczenie opinii dla \':item\'',
    'opinions_existing_translations' => 'Istniejące tłumaczenia dla \':item\'',
    'opinions_add_success' => 'Pomyślnie dodano nową opinię.',
    'opinions_update_success' => 'Pomyślnie zaktualizowano opinię.',
    'opinions_delete_confirm' => 'Czy na pewno chcesz usunąć tłumaczenie opinii: \':item\'?',
    'opinions_edit_translation' => 'Edytuj tłumaczenie opinii dla \':item\'',
    'opinions_edit_image_info' => 'Zmiana zdjęcia wpływa na wszystkie tłumaczenia.',

    // About me
    'about_table_title' => 'O mnie',
    'about_table_subtitle' => 'Zarządzaj sekcją O mnie na stronie',
    'about_add_opinion' => 'Dodaj nowy wpis',
    'about_add_translation' => 'Dodaj tłumaczenie wpisu (\':item\' w kolejności)',
    'about_existing_translations' => 'Istniejące tłumaczenia dla (\':item\' w kolejności)',
    'about_add_success' => 'Pomyślnie dodano nowy wpis.',
    'about_update_success' => 'Pomyślnie zaktualizowano wpis.',
    'about_delete_confirm' => 'Czy na pewno chcesz usunąć tłumaczenie wpisu (\':item\' w kolejności)?',
    'about_edit_translation' => 'Edytuj tłumaczenie wpisu (\':item\' w kolejności)',
    'about_edit_image_info' => 'Zmiana zdjęcia wpływa na wszystkie tłumaczenia.',

    // Tables - Columns
    'users_logins_table_columns' => [
        'id' => 'ID',
        'name' => 'Nazwa',
        'email' => 'E-mail',
        'email_verified_at' => 'Data weryfikacji',
        'last_login_at' => 'Data ostatniego logowania',
        'login_count' => 'Łączna liczba logowań',
    ],

    'opinions_table_columns' => [
        'image' => 'Zdjęcie',
        'first_name' => 'Imię',
        'country_code' => 'Kraj',
        'content' => 'Opinia',
        'order' => 'Kolejność',
        'visible' => 'Widoczność',
        'locale' => 'Język',
        'options' => 'Opcje',

        'image_alt' => 'Alternatywny tekst zdjęcia',
        'label_meta' => 'Etykieta meta',
        'rating' => 'Ocena',
        'slug' => 'Slug',
    ],

    'abouts_table_columns' => [
        'image' => 'Zdjęcie',
        'image_alt' => 'Alternatywny tekst zdjęcia',
        'content' => 'Treść',
        'main_page' => 'Strona główna',
        'order' => 'Kolejność',
        'visible' => 'Widoczność',
        'locale' => 'Język',
        'options' => 'Opcje',
    ],

];
