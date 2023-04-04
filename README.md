# go-wisata.id

> https://go-wisata.id/login = page login user 

> https://go-wisata.id/login-admin = page login admin


# daftar roles 
> id  name

> 1 = admin 	as Super Admin

> 2 = wisata 	as Admin Wisata

> 3 = kuliner as Admin Kuliner

> 4 = penginapan as Admin Penginapan

> 5 = pelanggan as User	

> 6 = desa 	  as Admin Desa

> 7 = event & sewa tempat 	

> 8 = seni & budaya 


# how to use 
1. git pull using https
2. composer  install (if required)
3. Import the newest db to your own database
4. php artisan migrate --path=/database/migrations/2023_04_04_100533_add_parent_id_to_users_table.php
5. php artisan db:seed










