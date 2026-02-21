<?php

return [
    // Navigation
    'home' => 'Home',
    'login' => 'Login',
    'register' => 'Register',
    'logout' => 'Logout',
    'management_content' => 'Management Content',

    'opinions' => 'Opinions',
    'faqs' => 'FAQs',
    'about_me' => 'About Me',
    'products' => 'Products',
    'translations' => 'Translations',
    'translation' => 'Translation',
    'translation_exists' => 'Translation for the given language already exists.',
    'validation_failed' => 'Validation failed.',

    // Auth
    'name' => 'Name',
    'email' => 'Email',
    'password' => 'Password',
    'forgot_password' => 'Forgot Your Password?',
    'reset_password' => 'Reset Password',
    'remember_me' => 'Remember Me',
    'password_confirmation' => 'Confirm Password',
    'please_confirm_your_password' => 'Please confirm your password before continuing.',
    'send_password_reset_link' => 'Send Password Reset Link',
    'section_auth_bg_alt' => 'Background image of the admin panel authentication section',

    // Verification
    'verify_email' => 'Verify Email Address',
    'verification_link_sent' => 'A fresh verification link has been sent to your email address.',
    'check_email_for_verification' => 'Before proceeding, please check your email for a verification link.',
    'did_not_receive_email' => 'If you did not receive the email',
    'click_here_to_request_another' => 'click here to request another',

    // Meta titles
    'title_meta_login' => 'Login - Admin Panel',
    'title_meta_register' => 'Register - Admin Panel',
    'title_meta_verify_email' => 'Verify Email - Admin Panel',
    'title_meta_confirm' => 'Confirm Password - Admin Panel',
    'title_meta_email' => 'Email - Admin Panel',
    'title_meta_reset' => 'Reset Password - Admin Panel',
    'title_meta_home' => 'Home - Admin Panel',
    'title_meta_opinion' => 'Opinions - Admin Panel',
    'title_meta_about' => 'About Me - Admin Panel',


    // Tables - Titles
    'table_button_add' => 'Add :item',
    'table_button_edit' => 'Edit',
    'table_button_delete' => 'Delete',
    'table_button_view' => 'View',

    // Tables - Titles
    'modal_button_save' => 'Save',
    'modal_button_cancel' => 'Cancel',
    'modal_button_delete' => 'Delete',

    // Deletion
    'confirm_delete_title' => 'Confirm Deletion',
    'confirm_delete_content' => 'Are you sure you want to delete this?',
    'delete_success' => 'Element was deleted successfully.',
    'delete_failed' => 'Deletion failed.',
    'error_relation_mismatch' => 'Error: relation mismatch.',
    'error_bad_url' => 'Error: bad URL.',
    'deleted' => 'Deleted.',
    'deleting' => 'Deleting...',


    'users_logins_table_title' => 'Users and Recent Logins',
    'users_logins_table_subtitle' => 'View recent user logins',

    // Opinions
    'opinions_table_title' => 'Opinions',
    'opinions_table_subtitle' => 'Manage reviews on your website',
    'opinions_add_opinion' => 'Add new opinion',
    'opinions_add_translation' => 'Add translation for opinion: :item',
    'opinions_existing_translations' => 'Existing translations for opinion: :item',
    'opinions_add_success' => 'Successfully added new opinion.',
    'opinions_update_success' => 'Successfully updated opinion.',
    'opinions_delete_confirm' => 'Are you sure you want to delete the translation of the opinion: \':item\'?',
    'opinions_edit_translation' => 'Edit translation for opinion: \':item\'',
    'opinions_edit_image_info' => 'Changing the image will affect all translations.',

    // About me
    'about_table_title' => 'About Me',
    'about_table_subtitle' => 'Manage the About Me section on the website',
    'about_add_opinion' => 'Add new entry',
    'about_add_translation' => 'Add translation for entry (\':item\' in order)',
    'about_existing_translations' => 'Existing translations for (\':item\' in order)',
    'about_add_success' => 'Successfully added new entry.',
    'about_update_success' => 'Successfully updated entry.',
    'about_delete_confirm' => 'Are you sure you want to delete the translation of the entry (\':item\' in order)?',
    'about_edit_translation' => 'Edit translation for entry (\':item\' in order)',
    'about_edit_image_info' => 'Changing the image will affect all translations.',


    // Tables - Columns
    'users_logins_table_columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'email' => 'Email',
        'email_verified_at' => 'Email Verified At',
        'last_login_at' => 'Last Login At',
        'login_count' => 'Total Logins',
    ],

    'opinions_table_columns' => [
        'image' => 'Image',
        'first_name' => 'Name',
        'country_code' => 'Country',
        'content' => 'Opinion',
        'order' => 'Order',
        'visible' => 'Visibility',
        'locale' => 'Language',
        'options' => 'Options',
    ],

    'abouts_table_columns' => [
        'image' => 'Image',
        'image_alt' => 'Alternative Text',
        'content' => 'Content',
        'main_page' => 'Main Page',
        'order' => 'Order',
        'visible' => 'Visibility',
        'locale' => 'Language',
        'options' => 'Options',
    ],
];
