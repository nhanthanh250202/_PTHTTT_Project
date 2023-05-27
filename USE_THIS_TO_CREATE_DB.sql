/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     23/05/2023 07:30:09 AM                       */
/*==============================================================*/


alter table PHIEUDAT 
   drop foreign key FK_PHIEUDAT_COLOAI_LOAIDICH;

alter table PHIEUDAT 
   drop foreign key FK_PHIEUDAT_DAT_KHACHHAN;

alter table PHIEUDAT 
   drop foreign key FK_PHIEUDAT_DAT_PHONG_PHONG;

alter table PHIEUDAT 
   drop foreign key FK_PHIEUDAT_NHAN_PHON_NHANVIEN;

alter table THANHTOAN 
   drop foreign key FK_THANHTOA_THANHTOAN_KHUYENMA;

alter table THANHTOAN 
   drop foreign key FK_THANHTOA_THANHTOAN_PHIEUDAT;

alter table THUOC 
   drop foreign key FK_THUOC_THUOC_PHONG;

alter table THUOC 
   drop foreign key FK_THUOC_THUOC2_THIETBI;

drop table if exists KHACHHANG;

drop table if exists KHUYENMAI;

drop table if exists LOAIDICHVU;

drop table if exists NHANVIEN;


alter table PHIEUDAT 
   drop foreign key FK_PHIEUDAT_DAT_PHONG_PHONG;

alter table PHIEUDAT 
   drop foreign key FK_PHIEUDAT_NHAN_PHON_NHANVIEN;

alter table PHIEUDAT 
   drop foreign key FK_PHIEUDAT_COLOAI_LOAIDICH;

alter table PHIEUDAT 
   drop foreign key FK_PHIEUDAT_DAT_KHACHHAN;

drop table if exists PHIEUDAT;

drop table if exists PHONG;


alter table THANHTOAN 
   drop foreign key FK_THANHTOA_THANHTOAN_KHUYENMA;

alter table THANHTOAN 
   drop foreign key FK_THANHTOA_THANHTOAN_PHIEUDAT;

drop table if exists THANHTOAN;

drop table if exists THIETBI;


alter table THUOC 
   drop foreign key FK_THUOC_THUOC_PHONG;

alter table THUOC 
   drop foreign key FK_THUOC_THUOC2_THIETBI;

drop table if exists THUOC;

/*==============================================================*/
/* Table: KHACHHANG                                             */
/*==============================================================*/
create table KHACHHANG
(
   MAKH                 varchar(14) not null  comment '',
   TENKH                national varchar(50)  comment '',
   SDTKH                char(10)  comment '',
   primary key (MAKH)
);

/*==============================================================*/
/* Table: KHUYENMAI                                             */
/*==============================================================*/
create table KHUYENMAI
(
   MAKM                 varchar(15) not null  comment '',
   TENKM                text  comment '',
   NGAYBATDAU           date  comment '',
   NGAYKETHUC           date  comment '',
   GIATRIKM             float  comment '',
   LOAIKM               smallint  comment '',
   DIEUKIEN             int  comment '',
   primary key (MAKM)
);

/*==============================================================*/
/* Table: LOAIDICHVU                                            */
/*==============================================================*/
create table LOAIDICHVU
(
   MADV                 varchar(10) not null  comment '',
   TENDV                national varchar(30)  comment '',
   DONGIADV             float(10,0)  comment '',
   primary key (MADV)
);

/*==============================================================*/
/* Table: NHANVIEN                                              */
/*==============================================================*/
create table NHANVIEN
(
   MANV                 varchar(10) not null  comment '',
   PASSWORD             char(20)  comment '',
   TENNV                national varchar(50)  comment '',
   CHUCVU               smallint  comment '',
   NGAYSINH             date  comment '',
   GIOITINH             smallint  comment '',
   DIACHI               national varchar(30)  comment '',
   SDTNV                char(10)  comment '',
   NGAY                 date  comment '',
   primary key (MANV)
);

/*==============================================================*/
/* Table: PHIEUDAT                                              */
/*==============================================================*/
create table PHIEUDAT
(
   MANV                 varchar(10)  comment '',
   MAKH                 varchar(14)  comment '',
   MAPHONG              varchar(5)  comment '',
   MADV                 varchar(10)  comment '',
   INDEX                int not null  comment '',
   MAPD                 varchar(20)  comment '',
   GIODAT               datetime  comment '',
   GIOVAO               datetime  comment '',
   GIORA                datetime  comment '',
   SOTIENCOC            float(8,2)  comment '',
   GHICHU               text  comment '',
   key AK_INDEX (INDEX)
);

/*==============================================================*/
/* Table: PHONG                                                 */
/*==============================================================*/
create table PHONG
(
   MAPHONG              varchar(5) not null  comment '',
   TENPHONG             varchar(20)  comment '',
   LOAIPHONG            smallint  comment '',
   TRANGTHAI            bool  comment '',
   primary key (MAPHONG)
);

/*==============================================================*/
/* Table: THANHTOAN                                             */
/*==============================================================*/
create table THANHTOAN
(
   MAKM                 varchar(15) not null  comment '',
   MAHD                 varchar(10)  comment '',
   TONGTIEN             float(8,2)  comment '',
   TONGKM               float(8,2)  comment '',
   primary key (MAKM)
);

/*==============================================================*/
/* Table: THIETBI                                               */
/*==============================================================*/
create table THIETBI
(
   MATB                 varchar(10) not null  comment '',
   TENTB                national varchar(30)  comment '',
   primary key (MATB)
);

/*==============================================================*/
/* Table: THUOC                                                 */
/*==============================================================*/
create table THUOC
(
   MAPHONG              varchar(5) not null  comment '',
   MATB                 varchar(10) not null  comment '',
   TINHTRANG            bool  comment '',
   GHICHUTB             text  comment '',
   primary key (MAPHONG, MATB)
);

alter table PHIEUDAT add constraint FK_PHIEUDAT_COLOAI_LOAIDICH foreign key (MADV)
      references LOAIDICHVU (MADV) on delete CASCADE on update CASCADE;

alter table PHIEUDAT add constraint FK_PHIEUDAT_DAT_KHACHHAN foreign key (MAKH)
      references KHACHHANG (MAKH) on delete CASCADE on update CASCADE;

alter table PHIEUDAT add constraint FK_PHIEUDAT_DAT_PHONG_PHONG foreign key (MAPHONG)
      references PHONG (MAPHONG) on delete CASCADE on update CASCADE;

alter table PHIEUDAT add constraint FK_PHIEUDAT_NHAN_PHON_NHANVIEN foreign key (MANV)
      references NHANVIEN (MANV) on delete CASCADE on update CASCADE;

alter table THANHTOAN add constraint FK_THANHTOA_THANHTOAN_KHUYENMA foreign key (MAKM)
      references KHUYENMAI (MAKM) on delete CASCADE on update CASCADE;

alter table THANHTOAN add constraint FK_THANHTOA_THANHTOAN_PHIEUDAT foreign key ()
      references PHIEUDAT on delete CASCADE on update CASCADE;

alter table THUOC add constraint FK_THUOC_THUOC_PHONG foreign key (MAPHONG)
      references PHONG (MAPHONG) on delete CASCADE on update CASCADE;

alter table THUOC add constraint FK_THUOC_THUOC2_THIETBI foreign key (MATB)
      references THIETBI (MATB) on delete CASCADE on update CASCADE;

