<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ön uç uygulama çevirileri
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları ön uç uygulaması için kullanılır.
    |
    */

    'users' => [
        'status' => [
            'verified' => 'Doğrulandı',
            'not_verified' => 'Doğrulanmadı',
            'ask_verify' => 'E-posta Doğrula',
        ],
        'roles' => [
            'regular' => 'Standart',
            'admin' => 'Yönetici',
        ],
        'labels' => [
            'id' => 'ID',
            'id_pound' => '#',
            'first_name' => 'Ad',
            'last_name' => 'Soyad',
            'middle_name' => 'İkinci Ad',
            'name' => 'Adı',
            'avatar' => 'Avatar',
            'email' => 'E-posta',
            'role' => 'Rol',
            'roles' => 'Roller',
            'status' => 'Durum',
            'current_password' => 'Mevcut Şifre',
            'password' => 'Şifre',
            'new_password' => 'Yeni Şifre',
            'confirm_password' => 'Şifreyi Onayla',
            'ask_upload_avatar' => 'Avatar Yükle',
            'new_record' => 'Yeni Kullanıcı',
            'edit_record' => 'Kullanıcıyı Düzenle',
            'general_settings' => 'Genel Ayarlar',
            'password_settings' => 'Şifre Ayarları',
            'avatar_settings' => 'Avatar Ayarları',
        ],
    ],

    'messages' => [
        'name' => 'Mesaj',
    ],
    'global' => [
        'pages' => [
            'home' => 'Kontrol Paneli',
            'users' => 'Kullanıcılar',
            'garage' => 'Garajlar',
            'sbm' => 'Sbm',
            'users_create' => 'Yeni Kullanıcı',
            'users_edit' => 'Kullanıcıyı Düzenle',
            'profile' => 'Profil',
            'register' => 'Kayıt Ol',
            'login' => 'Giriş Yap',
            'logout' => 'Çıkış Yap',
            'forgot_password' => 'Şifremi Unuttum',
            'reset_password' => 'Şifreyi Sıfırla',
        ],
        'phrases' => [
            'clear_filters' => 'Filtreleri Temizle',
            'loading' => 'Yükleniyor...',
            'sign_out' => 'Çıkış Yap',
            'all_records' => 'Tüm Kayıtlar',
            'argh' => 'Ah!',
            'success' => 'Başarılı!',
            'fix_errors' => 'Lütfen aşağıdaki hataları düzeltin:',
            'no_records' => 'Kayıt bulunamadı.',
            'login_desc' => 'Zaten üye iseniz kolayca giriş yapın.',
            'login_not_verified' => 'Giriş yapabilmek için lütfen e-posta adresinizi doğrulayın.',
            'register_desc' => 'Hesabınız yoksa, kayıt olun.',
            'reset_password_desc' => 'Şifrenizi sıfırlamak için formu doldurun.',
            'login_ask' => 'Hesabınız var mı?',
            'register_ask' => 'Hesabınız yok mu?',
            'forgot_password_desc' => 'Şifrenizi unuttuysanız, aşağıdan sıfırlayın.',
            'forgot_password_ask' => 'Şifrenizi mi unuttunuz?',
            'forgot_password_login' => 'Şifrenizi buldunuz mu? Giriş yapın.',
            'already_registered_login' => 'Zaten kayıtlı mısınız? Giriş yapın.',
            'inspire' => 'Haydi eğlenceli bir şeyler inşa edelim!',
            'copyright' => sprintf('Telif Hakkı &copy; %s. %s. Tüm Hakları Saklıdır.', date('Y'), "Zirvem Otomotiv"),
            'record_created' => 'Kayıt başarıyla oluşturuldu.',
            'record_not_created' => 'Kayıt oluşturulamadı.',
            'record_updated' => 'Kayıt başarıyla güncellendi.',
            'record_not_updated' => 'Kayıt güncellenemedi.',
            'file_uploaded' => 'Dosya başarıyla yüklendi',
            'file_not_uploaded' => 'Dosya yüklenemedi',
            'password_updated' => 'Şifre başarıyla güncellendi',
            'password_not_updated' => 'Şifre güncellenemedi',
            'profile_updated' => 'Profil başarıyla güncellendi',
            'profile_not_updated' => 'Profil güncellenemedi',
            'not_found_title' => '404',
            'not_found_text' => 'Aradığınız sayfa burada değil.',
            'not_found_back' => 'Geri Dön',
            'input_files_select' => 'Dosyaları buraya sürükleyin ya da yüklemek için tıklayın | Dosyayı buraya sürükleyin ya da yüklemek için tıklayın',
            'input_files_selected' => '{count} dosya seçildi | {count} dosya seçildi',
            'email_verified' => 'E-posta başarıyla doğrulandı!',
            'member_since' => 'Üyelik tarihi: {date}',
            'verification_sent' => 'E-posta doğrulama bağlantısı gönderildi.',
        ],
        'buttons' => [
            'add_new' => 'Yeni Ekle',
            'filters' => 'Filtreler',
            'save' => 'Kaydet',
            'send' => 'Gönder',
            'submit' => 'Gönder',
            'login' => 'Giriş Yap',
            'register' => 'Kayıt Ol',
            'search' => 'Ara',
            'new_record' => 'Yeni Kayıt',
            'documentation' => 'ZİRVEM OTOMOTİV ©',
            'back' => 'Geri',
            'upload' => 'Yükle',
            'update' => 'Güncelle',
            'change_avatar' => 'Avatarı Değiştir',
        ],
        'actions' => [
            'name' => 'İşlemler',
            'edit' => 'Düzenle',
            'delete' => 'Sil',
        ],
        'alerts' => [
            'success' => 'Başarılı!',
            'warning' => 'Uyarı!',
            'danger' => 'Hata!',
            'confirm' => 'Onayla!',
            'confirm_action_message' => 'Bu işlemi yapmak istediğinizden emin misiniz?',
        ],
    ],
    'garage' => [
        'garage1' => 'Sarıyer',
        'garage2' => 'Kartal',
        'labels' => [
            'doc_number' => 'Dosya No',
            'plate' => 'Plaka',
            'system_id' => 'Sistem ID',
            'updated_at' => 'Tarih',
        ]
    ],
    'sbm' => [
        'plate' => 'Plaka',
        'plate_query' => "Plaka Sorgula",
        'old_query' => "Eski Sorgular",
        'errors' => [
            'plate_required' => 'Plaka Zorunlu Alan',
        ],
        'update_button' => 'Yeniden Oluştur',
        'labels' => [
            'id' => 'ID',
            'id_pound' => '#',
            'plate' => 'Plaka',
            'user_id' => 'Kullanıcı',
            'ended_date' => 'Bitiş Tarihi',
            'image' => 'Tramer',
        ],
    ],
    'roles' => [
        'menu_title' => 'Rol Yönetimi',
        'roles_list' => 'Roller',
        'permissions_for' => '{role} Rolü Yetkileri',
        'create_role' => 'Yeni Rol Oluştur',
        'edit_role' => 'Rolü Düzenle',
        'role_saved' => 'Rol başarıyla kaydedildi',
        'permissions_saved' => 'Yetkiler başarıyla güncellendi',
        'labels' => [
            'name' => 'Rol Adı',
            'title' => 'Görünen Ad'
        ]
    ],
];

