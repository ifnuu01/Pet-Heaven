create database pet_heaven;

use pet_heaven;

create table pengguna(
id int auto_increment primary key, 
username varchar(100) not null,
nama_depan varchar(50) not null,
nama_belakang varchar(50),
email varchar(100) not null,
password varchar(255) not null,
path_poto varchar(255) default '/assets/img/profiles/profile.jpg',
tanggal_lahir date,
jenis_kelamin enum('Pria', 'Wanita'),
nomor_hp varchar(13), 
role enum('User', 'Admin') default 'User',
tanggal_dibuat datetime default current_timestamp
);


create table jenis_hewan(
id int auto_increment primary key,
jenis_hewan varchar(100)
);


create table hewan(
id int auto_increment primary key,
nama_hewan varchar(100) not null,
jenis_hewan int not null,
warna varchar(100) not null,
berat decimal(10,2) not null,
harga decimal(10,2) not null,
jenis_kelamin enum('Jantan', 'Betina') not null,
tahapan_usia varchar(100) not null,
path_poto varchar(255) not null,
status boolean not null default 1,
tanggal_ditambahkan datetime default current_timestamp,
foreign key (jenis_hewan) references jenis_hewan(id) on delete cascade on update cascade
);

create table transaksi(
no_pembelian varchar(10) primary key,
id_pengguna int not null,
id_hewan int not null,
biaya_pengiriman decimal(10,2) not null default 20000,
pajak decimal(10,2) not null default 2000,
bukti_pembayaran varchar(255) not null,
status enum('Menunggu','Dikonfirmasi', 'Ditolak') default 'Menunggu',
waktu_pembayaran datetime default current_timestamp,
foreign key (id_pengguna) references pengguna(id) on delete cascade on update cascade,
foreign key (id_hewan) references hewan(id) on delete cascade on update cascade 
);

drop table notifikasi;
drop table transaksi;

create table alamat(
id int auto_increment primary key,
id_pengguna int not null,
provinsi varchar(200) not null,
kota_kabupaten varchar(200) not null,
kecamatan varchar(200) not null,
kelurahan varchar(200) not null,
jalan varchar(255) not null,
foreign key (id_pengguna) references pengguna(id) on delete cascade on update cascade 
);

create table notifikasi(
id int auto_increment primary key,
id_pengguna int not null,
no_pembelian varchar(10) not null,
message varchar(255) not null,
foreign key (id_pengguna) references pengguna(id) on delete cascade on update cascade,
foreign key (no_pembelian) references transaksi(no_pembelian) on delete cascade on update cascade 
);

show tables;

-- Triger untuk menambah no pembelian unik 10 digit cuy

DELIMITER //
CREATE TRIGGER before_insert_transaksi
BEFORE INSERT ON transaksi
FOR EACH ROW
BEGIN
    DECLARE new_no_pembelian VARCHAR(10);
    DECLARE random_no INT;

    -- Menghasilkan nomor acak 9 digit
    SET random_no = FLOOR(RAND() * 1000000000); -- Menghasilkan 9 digit
    SET new_no_pembelian = LPAD(random_no, 10, '0'); -- Menjadikan 10 digit dengan padding nol

    -- Memastikan bahwa no_pembelian yang dihasilkan unik
    WHILE EXISTS (SELECT 1 FROM transaksi WHERE no_pembelian = new_no_pembelian) DO
        SET random_no = FLOOR(RAND() * 1000000000); -- Menghasilkan 9 digit
        SET new_no_pembelian = LPAD(random_no, 10, '0'); -- Menjadikan 10 digit dengan padding nol
    END WHILE;

    SET NEW.no_pembelian = new_no_pembelian; -- Menyimpan nilai baru ke dalam kolom no_pembelian
END; //
DELIMITER ;

INSERT INTO pengguna (username, nama_depan, nama_belakang, email, password, tanggal_lahir, jenis_kelamin, nomor_hp, role) 
VALUES
('john_doe', 'John', 'Doe', 'john.doe@example.com', 'password123', '1990-01-01', 'Pria', '081234567890', 'User'),
('jane_smith', 'Jane', 'Smith', 'jane.smith@example.com', 'password456', '1995-05-15', 'Wanita', '081298765432', 'Admin'),
('michael_jones', 'Michael', 'Jones', 'michael.jones@example.com', 'password789', '1988-07-30', 'Pria', '082134567890', 'User');

select * from jenis_hewan;

INSERT INTO jenis_hewan (jenis_hewan) 
VALUES 
('Reptil'), 
('Hamster'), 
('Serangga');


INSERT INTO hewan (nama_hewan, jenis_hewan, warna, berat, harga, jenis_kelamin, tahapan_usia, path_poto) 
VALUES
('Bella', 1, 'Putih', 4.5, 1500000.00, 'Betina', 'Dewasa', '/assets/img/hewan/bella.jpg'),
('Max', 2, 'Coklat', 8.2, 2000000.00, 'Jantan', 'Dewasa', '/assets/img/hewan/max.jpg'),
('Goldfish', 3, 'Emas', 0.3, 50000.00, 'Betina', 'Bibit', '/assets/img/hewan/goldfish.jpg'),
('Tweety', 4, 'Kuning', 0.05, 250000.00, 'Betina', 'Dewasa', '/assets/img/hewan/tweety.jpg');

INSERT INTO transaksi (id_pengguna, id_hewan, biaya_pengiriman, pajak, bukti_pembayaran, status)
VALUES
(1, 1, 20000.00, 2000.00, '/assets/img/bukti_pembayaran/john_doe.jpg', 'Menunggu'),
(2, 2, 20000.00, 2000.00, '/assets/img/bukti_pembayaran/jane_smith.jpg', 'Dikonfirmasi'),
(3, 3, 20000.00, 2000.00, '/assets/img/bukti_pembayaran/michael_jones.jpg', 'Ditolak');

INSERT INTO alamat (id_pengguna, provinsi, kota_kabupaten, kecamatan, kelurahan, jalan)
VALUES
(1, 'Jawa Barat', 'Bandung', 'Cidadap', 'Sukajadi', 'Jl. Merdeka No. 5'),
(2, 'DKI Jakarta', 'Jakarta Selatan', 'Cilandak', 'Cipete', 'Jl. Raya Cipete No. 12'),
(3, 'Bali', 'Denpasar', 'Denpasar Selatan', 'Padangsambian', 'Jl. Sunset Road No. 8');

INSERT INTO notifikasi (id_pengguna, no_pembelian, message) 
VALUES
(1, '0509863556', 'Pembelian Anda sedang diproses.'),
(2, '0478827355', 'Pembelian Anda telah dikonfirmasi.'),
(3, '0112835747', 'Pembelian Anda ditolak karena pembayaran gagal.');


select * from hewan;

select 
	h.id,
	h.nama_hewan,
    h.path_poto,
    h.tahapan_usia,
    h.jenis_kelamin,
    j.jenis_hewan,
    h.harga,
    h.tanggal_ditambahkan
from hewan h
join jenis_hewan j on h.jenis_hewan = j.id 
where status = 1
LIMIT 0,2;


select 
	h. *,
    j.jenis_hewan
from hewan h
join jenis_hewan j on h.jenis_hewan = j.id
where h.id = 2;

delete from hewan where id = 2 and status = 1;



