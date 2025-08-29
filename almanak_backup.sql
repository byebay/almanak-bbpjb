--
-- PostgreSQL database dump
--

-- Dumped from database version 16.4
-- Dumped by pg_dump version 16.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: agendas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.agendas (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    description text NOT NULL,
    agenda_date date NOT NULL,
    start_time time(0) without time zone NOT NULL,
    end_time time(0) without time zone NOT NULL,
    file_path character varying(255),
    status character varying(255) DEFAULT 'Menunggu Validasi'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    room_id bigint
);


ALTER TABLE public.agendas OWNER TO postgres;

--
-- Name: agendas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.agendas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.agendas_id_seq OWNER TO postgres;

--
-- Name: agendas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.agendas_id_seq OWNED BY public.agendas.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: daily_attendances; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.daily_attendances (
    id bigint NOT NULL,
    ac_no character varying(255) NOT NULL,
    employee_name character varying(255) NOT NULL,
    date date NOT NULL,
    check_in_time time(0) without time zone,
    check_out_time time(0) without time zone,
    status character varying(255),
    notes text,
    imported_by_user_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT daily_attendances_status_check CHECK (((status)::text = ANY ((ARRAY['Hadir'::character varying, 'Terlambat'::character varying, 'Cuti'::character varying, 'Dinas Luar'::character varying, 'Tanpa Keterangan'::character varying])::text[])))
);


ALTER TABLE public.daily_attendances OWNER TO postgres;

--
-- Name: daily_attendances_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.daily_attendances_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.daily_attendances_id_seq OWNER TO postgres;

--
-- Name: daily_attendances_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.daily_attendances_id_seq OWNED BY public.daily_attendances.id;


--
-- Name: employee_works; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employee_works (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    year smallint NOT NULL,
    month smallint NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    file_path character varying(255) NOT NULL,
    file_type character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    work_date date
);


ALTER TABLE public.employee_works OWNER TO postgres;

--
-- Name: employee_works_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.employee_works_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.employee_works_id_seq OWNER TO postgres;

--
-- Name: employee_works_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.employee_works_id_seq OWNED BY public.employee_works.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: kinerja_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kinerja_details (
    id bigint NOT NULL,
    kinerja_id bigint NOT NULL,
    deskripsi_pekerjaan text NOT NULL,
    realisasi_target text NOT NULL,
    progres_kegiatan text NOT NULL,
    kendala text,
    strategi_penyelesaian text,
    file_bukti character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    pelaksana character varying(255)
);


ALTER TABLE public.kinerja_details OWNER TO postgres;

--
-- Name: kinerja_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kinerja_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.kinerja_details_id_seq OWNER TO postgres;

--
-- Name: kinerja_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kinerja_details_id_seq OWNED BY public.kinerja_details.id;


--
-- Name: kinerjas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kinerjas (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    judul_kegiatan character varying(255) NOT NULL,
    target_kinerja text NOT NULL,
    bulan_tahun date NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.kinerjas OWNER TO postgres;

--
-- Name: COLUMN kinerjas.bulan_tahun; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.kinerjas.bulan_tahun IS 'Untuk filter per bulan & tahun';


--
-- Name: kinerjas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kinerjas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.kinerjas_id_seq OWNER TO postgres;

--
-- Name: kinerjas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kinerjas_id_seq OWNED BY public.kinerjas.id;


--
-- Name: leave_records; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.leave_records (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    status character varying(255) NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT leave_records_status_check CHECK (((status)::text = ANY ((ARRAY['Cuti'::character varying, 'Dinas Luar'::character varying])::text[])))
);


ALTER TABLE public.leave_records OWNER TO postgres;

--
-- Name: leave_records_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.leave_records_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.leave_records_id_seq OWNER TO postgres;

--
-- Name: leave_records_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.leave_records_id_seq OWNED BY public.leave_records.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: rooms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rooms (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    location character varying(255),
    capacity integer,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.rooms OWNER TO postgres;

--
-- Name: rooms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.rooms_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.rooms_id_seq OWNER TO postgres;

--
-- Name: rooms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.rooms_id_seq OWNED BY public.rooms.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    nip character varying(255),
    email character varying(255) NOT NULL,
    birth_date date,
    photo_path character varying(255),
    role character varying(255) DEFAULT 'pegawai'::character varying NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['pegawai'::character varying, 'admin_kepegawaian'::character varying, 'admin_anggaran'::character varying, 'super_admin'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: agendas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agendas ALTER COLUMN id SET DEFAULT nextval('public.agendas_id_seq'::regclass);


--
-- Name: daily_attendances id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.daily_attendances ALTER COLUMN id SET DEFAULT nextval('public.daily_attendances_id_seq'::regclass);


--
-- Name: employee_works id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_works ALTER COLUMN id SET DEFAULT nextval('public.employee_works_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: kinerja_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kinerja_details ALTER COLUMN id SET DEFAULT nextval('public.kinerja_details_id_seq'::regclass);


--
-- Name: kinerjas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kinerjas ALTER COLUMN id SET DEFAULT nextval('public.kinerjas_id_seq'::regclass);


--
-- Name: leave_records id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leave_records ALTER COLUMN id SET DEFAULT nextval('public.leave_records_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: rooms id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms ALTER COLUMN id SET DEFAULT nextval('public.rooms_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: agendas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.agendas (id, user_id, title, description, agenda_date, start_time, end_time, file_path, status, created_at, updated_at, deleted_at, room_id) FROM stdin;
305	1	PKBI	Data diimpor dari almanak lama.	2025-07-01	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
306	1	PKBI 2. Tim Kerja UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kab. Indramayu.	Data diimpor dari almanak lama.	2025-07-02	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
307	1	PKBI	Data diimpor dari almanak lama.	2025-07-03	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
308	1	Kunjungan Edukasi MGMP Bahasa Indonesia SMP Pangandaran  3.  Tim Kerja UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kab. Indramayu.	Data diimpor dari almanak lama.	2025-07-03	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
309	1	Senam bersama Sesban	Data diimpor dari almanak lama.	2025-07-04	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
310	1	Sawala Sastra	Data diimpor dari almanak lama.	2025-07-04	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
311	1	PKBI	Data diimpor dari almanak lama.	2025-07-04	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
312	1	Kunjungan ke Komunitas Sastra Rancage	Data diimpor dari almanak lama.	2025-07-05	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
313	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung	Data diimpor dari almanak lama.	2025-07-07	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
314	1	Tim Kerja UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kab. Tasikmalaya.	Data diimpor dari almanak lama.	2025-07-08	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
315	1	Zoom Sawala Budaya  Sunda	Data diimpor dari almanak lama.	2025-07-08	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
316	1	1. Tim Kerja UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kab. Tasikmalaya.	Data diimpor dari almanak lama.	2025-07-09	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
317	1	Rapat Pengukuran Kinerja Triwulan II	Data diimpor dari almanak lama.	2025-07-10	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
318	1	Audiensi DPD Ikatan Mahasiswa Muhammadiyah Jawa Barat	Data diimpor dari almanak lama.	2025-07-10	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
319	1	Jaguar: jalan sehat	Data diimpor dari almanak lama.	2025-07-11	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
320	1	Simulasi Wawancara Desk Evaluasi ZI-WBK secara mandiri	Data diimpor dari almanak lama.	2025-07-11	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
321	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung.	Data diimpor dari almanak lama.	2025-07-14	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
322	1	KKLP UKBI: Pelaksanaan Kegiatan Pendampingan secara daring dalam proses pelaksanaan UKBI Adaptif kepada siswa SMAN 1 Patok Beusi Subang.	Data diimpor dari almanak lama.	2025-07-14	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
323	1	Tim Kerja UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kab. Kuningan.	Data diimpor dari almanak lama.	2025-07-15	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
324	1	Final Musikalisasi Puisi Jawa Barat	Data diimpor dari almanak lama.	2025-07-15	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
325	1	Tim Kerja UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kab. Kuningan.	Data diimpor dari almanak lama.	2025-07-16	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
326	1	Serah-terima mahasiswa magang dari UIN, UPI, dan Unpad.	Data diimpor dari almanak lama.	2025-07-17	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
327	1	Tenggat pengiriman Buku Cerita Anak Dwibahasa (bahasa Sunda-bahasa Indonesia) Tahun 2025	Data diimpor dari almanak lama.	2025-07-18	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
328	1	Tim Kerja UKBI: Sosialisasi UKBI kepada Guru MGMP Bahasa Indonesia Kab. Bandung di Balai Bahasa Provinsi Jawa Barat.	Data diimpor dari almanak lama.	2025-07-21	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
329	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung	Data diimpor dari almanak lama.	2025-07-21	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
330	1	Simulasi Wawancara Desk Evaluasi ZI-WBK secara mandiri	Data diimpor dari almanak lama.	2025-07-22	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
331	1	Simulasi Wawancara Desk Evaluasi ZI-WBK oleh Biro OSDM	Data diimpor dari almanak lama.	2025-07-23	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
332	1	Tim Kerja Molinbastra:	Data diimpor dari almanak lama.	2025-07-28	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
333	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025	Data diimpor dari almanak lama.	2025-07-28	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
334	1	Bimbingan Teknis (Bimtek) Cerdas Mengulas Buku bagi Siswa SD di Kabupaten	Data diimpor dari almanak lama.	2025-07-28	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
336	1	Siaran Pembinaan RRI	Data diimpor dari almanak lama.	2025-07-28	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
337	1	Tim Kerja Molinbastra:	Data diimpor dari almanak lama.	2025-07-29	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
338	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025.	Data diimpor dari almanak lama.	2025-07-29	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
339	1	Rapat Program Kolaborasi Disdikbud Indramayu	Data diimpor dari almanak lama.	2025-07-29	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
340	1	Webinar Kesehatan Mental	Data diimpor dari almanak lama.	2025-07-29	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
341	1	Tim Kerja Molinbastra:	Data diimpor dari almanak lama.	2025-07-30	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
342	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025.	Data diimpor dari almanak lama.	2025-07-30	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
343	1	Rapat Program Kolaborasi Disdikbud Indramayu	Data diimpor dari almanak lama.	2025-07-30	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
344	1	Tim Kerja Molinbastra:	Data diimpor dari almanak lama.	2025-07-31	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
345	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025	Data diimpor dari almanak lama.	2025-07-31	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
346	1	Pemaparan Progres Aplikasi oleh Mahasiswa Polban	Data diimpor dari almanak lama.	2025-07-31	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
347	1	Pembinaan Tim Pemenang Musikalisasi Puisi di SMA Negeri 5 Karawang	Data diimpor dari almanak lama.	2025-07-31	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 01:56:01	\N	\N
348	1	Tim Kerja Molinbastra:	Data diimpor dari almanak lama.	2025-08-01	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
349	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025	Data diimpor dari almanak lama.	2025-08-01	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
350	1	Pembinaan Tim Pemenang Musikalisasi Puisi di SMA Negeri 5 Karawang	Data diimpor dari almanak lama.	2025-08-01	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
351	1	Rapat Kerja Sama dengan Pemda Garut	Data diimpor dari almanak lama.	2025-08-01	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
352	1	Tim Kerja Molinbastra:	Data diimpor dari almanak lama.	2025-08-04	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
353	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025	Data diimpor dari almanak lama.	2025-08-04	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
354	1	Audiensi Pemerintah Provinsi Jawa Barat	Data diimpor dari almanak lama.	2025-08-04	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
355	1	Siaran Pembinaan RRI	Data diimpor dari almanak lama.	2025-08-04	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
356	1	Tim Kerja Molinbastra:	Data diimpor dari almanak lama.	2025-08-05	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
357	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025	Data diimpor dari almanak lama.	2025-08-05	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
358	1	Pembinaan Komunitas Penggerak Literasi di Kota Bogor	Data diimpor dari almanak lama.	2025-08-05	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
359	1	Audiensi Pemerintah Kota Cimahi	Data diimpor dari almanak lama.	2025-08-05	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
361	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025	Data diimpor dari almanak lama.	2025-08-06	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
362	1	Pembinaan Komunitas Penggerak Literasi di Kota Bogor	Data diimpor dari almanak lama.	2025-08-06	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
364	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025	Data diimpor dari almanak lama.	2025-08-07	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
365	1	Audiensi Universitas Sultan Ageng Tirtatayasa	Data diimpor dari almanak lama.	2025-08-07	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
366	1	Pembinaan Komunitas Penggerak Literasi di Kota Bogor	Data diimpor dari almanak lama.	2025-08-07	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
368	1	Pengambilan Data Peta Kebinekaan Bahasa, Sastra, dan Aksara Tahun 2025	Data diimpor dari almanak lama.	2025-08-08	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
369	1	Pembinaan Komunitas Penggerak Literasi di Kota Bogor	Data diimpor dari almanak lama.	2025-08-08	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
370	1	Sosialisasi Program BIPA Sukabumi	Data diimpor dari almanak lama.	2025-08-11	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
371	1	Siaran Pembinaan RRI	Data diimpor dari almanak lama.	2025-08-11	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
372	1	PKBI Luring di Hotel Grand Sunshine	Data diimpor dari almanak lama.	2025-08-12	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
373	1	Pembinaan Tim Pemenang Musikalisasi Puisi di SMA Santa Maria 2	Data diimpor dari almanak lama.	2025-08-12	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
1609	1	Upacara Peringatan Hari Pendidikan Nasional Tahun 2025	Data diimpor dari almanak lama.	2025-05-02	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
375	1	Sosialisasi Program BIPA Sukabumi	Data diimpor dari almanak lama.	2025-08-12	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
376	1	PKBI Luring di Hotel Grand Sunshine	Data diimpor dari almanak lama.	2025-08-13	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
377	1	Sosialisasi Program BIPA Sukabumi	Data diimpor dari almanak lama.	2025-08-13	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
378	1	PKBI Luring di Hotel Grand Sunshine	Data diimpor dari almanak lama.	2025-08-14	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
379	1	Harmoni Merah Putih	Data diimpor dari almanak lama.	2025-08-14	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
380	1	PKBI Daring	Data diimpor dari almanak lama.	2025-08-18	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
381	1	Penganugerahan Galunggung Award	Data diimpor dari almanak lama.	2025-08-18	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
382	1	PKBI Daring	Data diimpor dari almanak lama.	2025-08-19	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
383	1	Penganugerahan Galunggung Award	Data diimpor dari almanak lama.	2025-08-19	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
384	1	Sidang Komisi Istilah	Data diimpor dari almanak lama.	2025-08-19	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
385	1	Rapat Persiapan Wawancara ZI WBK	Data diimpor dari almanak lama.	2025-08-19	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
386	1	PKBI Daring	Data diimpor dari almanak lama.	2025-08-20	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
387	1	Sidang Komisi Istilah	Data diimpor dari almanak lama.	2025-08-20	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
388	1	Pembekalan Duta Bahasa Nasional	Data diimpor dari almanak lama.	2025-08-20	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
389	1	Rapat Penyusunan POS Mekanisme Kerja	Data diimpor dari almanak lama.	2025-08-20	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
367	1	Tim Kerja Molinbastra:	Data diimpor dari almanak lama.	2025-08-08	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-25 02:00:37	2025-08-25 02:00:37	\N
360	1	Tim Kerja Molinbastra	Data diimpor dari almanak lama.	2025-08-06	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-25 02:14:19	\N	\N
363	1	Tim Kerja Molinbastra	Data diimpor dari almanak lama.	2025-08-07	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-25 02:14:39	\N	\N
390	1	PKBI Daring	Data diimpor dari almanak lama.	2025-08-21	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
391	1	Sidang Komisi Istilah	Data diimpor dari almanak lama.	2025-08-21	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
392	1	Pembekalan Duta Bahasa Nasional	Data diimpor dari almanak lama.	2025-08-21	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
393	1	Kunjungan Sekretariat Badan Bahasa	Data diimpor dari almanak lama.	2025-08-21	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
394	1	Sidang Komisi Istilah	Data diimpor dari almanak lama.	2025-08-22	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
395	1	Pembekalan Duta Bahasa Nasional	Data diimpor dari almanak lama.	2025-08-22	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
396	1	Wawancara ZI WBK	Data diimpor dari almanak lama.	2025-08-22	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
397	1	Rapat Renovasi Gedung	Data diimpor dari almanak lama.	2025-08-23	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
398	1	Sidang Komisi Istilah	Data diimpor dari almanak lama.	2025-08-25	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
399	1	Audiensi Pengawasan dan Pelindungan dengan Pemda KBB	Data diimpor dari almanak lama.	2025-08-25	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
400	1	Sidang Komisi Istilah 2. Tim Kerja UKBI: Pendampingan secara luring proses pelaksanaan UKBI Adaptif Siswa SMA BPI Bandung	Data diimpor dari almanak lama.	2025-08-26	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
401	1	Sidang Komisi Istilah	Data diimpor dari almanak lama.	2025-08-27	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
402	1	Audiensi ke Pemda Purwakarta	Data diimpor dari almanak lama.	2025-08-27	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
403	1	Sidang Komisi Istilah	Data diimpor dari almanak lama.	2025-08-28	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-22 02:01:44	\N	\N
335	1	Bandung.	Data diimpor dari almanak lama.	2025-07-28	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 01:56:01	2025-08-22 02:04:09	2025-08-22 02:04:09	\N
374	1	Bandung	Data diimpor dari almanak lama.	2025-08-12	08:00:00	17:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-25 01:49:15	2025-08-25 01:49:15	\N
404	1	Sidang Komisi Istilah	Data diimpor dari almanak lama.	2025-08-29	08:00:00	16:00:00	\N	Terpublikasi	2025-08-22 02:01:44	2025-08-25 02:16:33	\N	\N
405	1	Program Jaguar: Jalan Sehat	Data diimpor dari almanak lama.	2025-01-03	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
406	1	Agenda Kepala Balai: Pendampingan Wakil Menteri Dikdasmen ke Kabupaten Garut	Data diimpor dari almanak lama.	2025-01-03	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
407	1	Agenda Kepala Balai: Pendampingan Wakil Menteri Dikdasmen ke Kabupaten Garut	Data diimpor dari almanak lama.	2025-01-04	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
408	1	Agenda Kepala Balai: Pendampingan Wakil Menteri Dikdasmen ke Kabupaten Garut	Data diimpor dari almanak lama.	2025-01-05	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
409	1	Apel Pagi	Data diimpor dari almanak lama.	2025-01-06	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
410	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung	Data diimpor dari almanak lama.	2025-01-06	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
411	1	Sosialisasi PPID dan Keterbukaan Informasi Publik	Data diimpor dari almanak lama.	2025-01-08	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
412	1	Rapat Program Kerja dan Prognosis Tahun 2025	Data diimpor dari almanak lama.	2025-01-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
413	1	Apel Pagi	Data diimpor dari almanak lama.	2025-01-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
414	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung	Data diimpor dari almanak lama.	2025-01-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
415	1	Rapat Penyusunan Laporan Layanan Informasi	Data diimpor dari almanak lama.	2025-01-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
416	1	Rapat Penyuluh Bahasa	Data diimpor dari almanak lama.	2025-01-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
417	1	Rapat Penyusunan Standar Pelayanan dan PKL	Data diimpor dari almanak lama.	2025-01-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
418	1	Rapat Konsolidasi UPT Kemdikdasmen di Jawa Barat	Data diimpor dari almanak lama.	2025-01-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
419	1	Program Jaguar: Kerja Bakti	Data diimpor dari almanak lama.	2025-01-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
420	1	Rapat Tindak Lanjut PPID	Data diimpor dari almanak lama.	2025-01-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
421	1	Rapat Sinergitas Program Balai Bahasa Provinsi Jawa Barat bersama Ikatan Duta Bahasa Jawa Barat	Data diimpor dari almanak lama.	2025-01-18	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
422	1	Apel Pagi	Data diimpor dari almanak lama.	2025-01-20	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
423	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung	Data diimpor dari almanak lama.	2025-01-20	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
424	1	Rapat Tindak Lanjut Penyusunan Laporan Layanan Informasi Publik	Data diimpor dari almanak lama.	2025-01-20	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
425	1	KKLP Pembahu: PUMA bagi Pegawai BBPJB	Data diimpor dari almanak lama.	2025-01-20	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
426	1	Rapat Reviu LAKIN 2024	Data diimpor dari almanak lama.	2025-01-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
427	1	Audiensi dengan Kapolrestabes Kota Bandung	Data diimpor dari almanak lama.	2025-01-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
428	1	Sosialisasi LAKIN 2024	Data diimpor dari almanak lama.	2025-01-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
429	1	Kerja Lembur Finalisasi Laporan Kinerja Tahun 2024	Data diimpor dari almanak lama.	2025-01-29	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
430	1	Gebyar Guru Hebring Menuju Transformasi Pendidikan Nasional di GOR Tadjimalela Sumedang	Data diimpor dari almanak lama.	2025-01-30	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:27	2025-08-25 02:24:27	\N	\N
431	1	Agenda Kepala Balai: Halalbihalal di Lingkungan Kemdikdasmen	Data diimpor dari almanak lama.	2025-04-08	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
432	1	KKLP Pembahu: Pendampingan I Peningkatan Kemahiran Berbahasa Indonesia (PKBI) Penulis dan Penerjemah dengan materi Ejaan	Data diimpor dari almanak lama.	2025-04-08	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
433	1	Rapat Penyelarasan Program dan Pembangunan ZI WBK	Data diimpor dari almanak lama.	2025-04-09	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
434	1	Kuliah Umum Linguistik (Badan)	Data diimpor dari almanak lama.	2025-04-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
435	1	Agenda Kepala Balai: Pendampingan dan Pelepasan Menteri Pendidikan Dasar dan Menengah	Data diimpor dari almanak lama.	2025-04-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
436	1	KKLP Pembahu: Pendampingan I Peningkatan Kemahiran Berbahasa Indonesia (PKBI) Penulis dan Penerjemah dengan Materi Menulis	Data diimpor dari almanak lama.	2025-04-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
437	1	Jaguar: Kerja Bakti (Laila)	Data diimpor dari almanak lama.	2025-04-11	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
438	1	Zoom: Tugas Belajar (Badan)	Data diimpor dari almanak lama.	2025-04-11	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
439	1	Apel Pagi	Data diimpor dari almanak lama.	2025-04-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
440	1	Forum Diskusi Daring Seri VI (Pembahu)	Data diimpor dari almanak lama.	2025-04-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
441	1	Diskusi Publik: Bahasa Daerah di Provinsi Jawa Barat	Data diimpor dari almanak lama.	2025-04-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
442	1	Zoom: Halal Bihalal bersama Pak Menteri (Badan)	Data diimpor dari almanak lama.	2025-04-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
443	1	Rapat Evaluasi Triwulan I, Pelaksanaan Kegiatan Triwulan II, dan Pencanangan Inovasi Layanan ZI WBK	Data diimpor dari almanak lama.	2025-04-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
444	1	Pengencekan Data Dukung ZI WBK	Data diimpor dari almanak lama.	2025-04-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
445	1	KKLP Pembahu: Zoom Pendampingan Peningkatan Kemahiran Berbahasa Indonesia	Data diimpor dari almanak lama.	2025-04-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
446	1	Agenda Kepala Balai : Audiensi Bersama Komisi X DPR RI	Data diimpor dari almanak lama.	2025-04-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
447	1	Pengecekan dakung ZI-WBK.	Data diimpor dari almanak lama.	2025-04-16	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
448	1	KKLP UKBI: pendampingan pelaksanaan UKBI secara daring kepada siswa di SMAT Krida Nusantara Bandung (270 siswa).	Data diimpor dari almanak lama.	2025-04-16	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
449	1	Pengecekan dakung ZI-WBK	Data diimpor dari almanak lama.	2025-04-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
450	1	KKLP Pembahu: Pendampingan PKBI Penulis dan Penerjemah dengan materi Kalimat dan Paragraf	Data diimpor dari almanak lama.	2025-04-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
451	1	Apel Pagi	Data diimpor dari almanak lama.	2025-04-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
452	1	KKLP Pembahu: Pendampingan II Peningkatan Kemahiran Berbahasa Indonesia (PKBI) Penulis dan Penerjemah dengan materi Ejaan	Data diimpor dari almanak lama.	2025-04-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
453	1	KKLP UKBI: Pelaksanaan Kegiatan Pendampingan secara daring dalam proses pelaksanaan UKBI Adaptif kepada siswa SMKN 2 Sumedang, SMK Cipta Skill Bandung, dan Mahasiswa BIPA UPI Bandung.	Data diimpor dari almanak lama.	2025-04-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
454	1	Sosialisai dan Diseminasi POS 2025, Antigratifikasi, Bebas Benturan Kepentinga Whistle Blowing System, dan SPI.	Data diimpor dari almanak lama.	2025-04-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
455	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung. 6. KKLP KI : Pengambilan Data Inventarisasi Kosakata di Kabupaten Tasikmalaya	Data diimpor dari almanak lama.	2025-04-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
456	1	KKLP UKBI: Pelaksanaan Kegiatan Pendampingan secara daring dalam proses pelaksanaan UKBI Adaptif kepada siswa SMKN 2 Sumedang.	Data diimpor dari almanak lama.	2025-04-22	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
457	1	Rapat Inovasi Balai Bahasa Provinsi Jawa Barat bersama Agen Perubahan dan Penanggung Jawab Inovasi.	Data diimpor dari almanak lama.	2025-04-22	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
458	1	KKLP Molinbastra: Zoom Persiapan FTBI Nasional 2025	Data diimpor dari almanak lama.	2025-04-22	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
459	1	Rapat Potensi Kerja Sama antara Badan Bahasa dan PT KAI yang diseleggarakan Sekretariat Badan Bahasa secara daring. 5. KKLP KI : Pengambilan Data Inventarisasi Kosakata di Kabupaten Tasikmalaya	Data diimpor dari almanak lama.	2025-04-22	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
460	1	KKLP UKBI: Pelaksanaan Kegiatan Pendampingan secara daring dalam proses pelaksanaan UKBI Adaptif kepada siswa SMKN 2 Sumedang.	Data diimpor dari almanak lama.	2025-04-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
461	1	Kunjungan Kerja KITLV Universiteit Leiden	Data diimpor dari almanak lama.	2025-04-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
462	1	KKLP Pembahu: Zoom Pendampingan Peningkatan Kemahiran Berbahasa Indonesia 4. KKLP KI : Pengambilan Data Inventarisasi Kosakata di Kabupaten Tasikmalaya	Data diimpor dari almanak lama.	2025-04-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
463	1	KKLP UKBI: Pelaksanaan Kegiatan Pendampingan secara daring dalam proses pelaksanaan UKBI Adaptif kepada siswa SMKN 2 Sumedang.	Data diimpor dari almanak lama.	2025-04-24	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
464	1	KKLP Pembahu: Zoom Pendampingan Peningkatan Kemahiran Berbahasa Indonesia 3. KKLP KI : Pengambilan Data Inventarisasi Kosakata di Kabupaten Tasikmalaya	Data diimpor dari almanak lama.	2025-04-24	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
465	1	KKLP KI : Pengambilan Data Inventarisasi Kosakata di Kabupaten Tasikmalaya	Data diimpor dari almanak lama.	2025-04-25	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:58	2025-08-25 02:24:58	\N	\N
466	1	Apel Pagi	Data diimpor dari almanak lama.	2025-04-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
467	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Diseminasi dan Sosialisasi UKBI kepada pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kabupaten Subang.	Data diimpor dari almanak lama.	2025-04-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
468	1	Konsolidasi Nasional Pendidikan Dasar dan Menengah Tahun 2025 di PPSDM Depok.	Data diimpor dari almanak lama.	2025-04-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
1695	1	Rapat Penelaahan RKAKL	Data diimpor dari almanak lama.	2025-06-05	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
469	1	KKLP Pembahu: Zoom Pendampingan Peningkatan Kemahiran Berbahasa Indonesia	Data diimpor dari almanak lama.	2025-04-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
470	1	Obrolan Siang bersama Balai Bahasa di Pro 1 RRI Bandung "Literasi untuk Semua" oleh Nandang R. Pamungkas	Data diimpor dari almanak lama.	2025-04-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
471	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Diseminasi dan Sosialisasi UKBI kepada pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kabupaten Subang.	Data diimpor dari almanak lama.	2025-04-29	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
472	1	Konsolidasi Nasional Pendidikan Dasar dan Menengah Tahun 2025 di PPSDM Depok.	Data diimpor dari almanak lama.	2025-04-29	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
473	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Diseminasi dan Sosialisasi UKBI kepada pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kabupaten Subang.	Data diimpor dari almanak lama.	2025-04-30	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
474	1	Konsolidasi Nasional Pendidikan Dasar dan Menengah Tahun 2025 di PPSDM Depok.	Data diimpor dari almanak lama.	2025-04-30	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
475	1	KKLP Pembahu: Zoom Pendampingan Peningkatan Kemahiran Berbahasa Indonesia.	Data diimpor dari almanak lama.	2025-04-30	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:24:59	2025-08-25 02:24:59	\N	\N
476	1	Apel Pagi	Data diimpor dari almanak lama.	2025-03-03	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
477	1	Rapat Koordinasi Alih Daya Balai Bahasa Provinsi Jawa Barat	Data diimpor dari almanak lama.	2025-03-04	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
478	1	KKLP UKBI : pendampingan pelaksanaan UKBI secara daring kepada siswa di SMA Al Azhar Syifa Budi Parahyangan KBB (292 Siswa)	Data diimpor dari almanak lama.	2025-03-05	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
479	1	KKLP Molinbastra: Rapat Koordinasi Persiapan Kegiatan RBD Tahun 2025	Data diimpor dari almanak lama.	2025-03-07	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
480	1	KKLP Penerjemahan: Peluncuran Sayembara Penulisan Cerita Anak Dwibasa Tahun 2025	Data diimpor dari almanak lama.	2025-03-07	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
481	1	Agenda Kepala Balai: Buka Puasa Bersama Komisi X DPR RI	Data diimpor dari almanak lama.	2025-03-09	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
482	1	Apel Pagi	Data diimpor dari almanak lama.	2025-03-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
483	1	Audiensi dengan DPRD Provinsi Jawa Barat	Data diimpor dari almanak lama.	2025-03-11	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
484	1	Zoom Badan Bahasa: Bimtek Keamanan Siber dan Data Privasi	Data diimpor dari almanak lama.	2025-03-12	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
485	1	KKLP Pembahu: Zoom PUMA bagi Guru SD Se-Kabupaten Pangandaran	Data diimpor dari almanak lama.	2025-03-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
486	1	KKLP BIPA: Fun Learning With Foreigner di Seqouia School	Data diimpor dari almanak lama.	2025-03-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
487	1	KKLP Pembahu: Zoom PUMA bagi Ikatan Duta Bahasa Jawa Barat	Data diimpor dari almanak lama.	2025-03-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
488	1	Apel Pagi	Data diimpor dari almanak lama.	2025-03-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
489	1	KKLP UKBI : pendampingan pelaksanaan UKBI secara daring kepada siswa di SMKN 2 Cilaku Kabupaten Cianjur (404 siswa)	Data diimpor dari almanak lama.	2025-03-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
490	1	KKLP Pembahu: Zoom Peningkatan Kemahiran Berbahasa Indonesia	Data diimpor dari almanak lama.	2025-03-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
491	1	KKLP UKBI: UKBI Adaptif di SMAN 2 Lembang	Data diimpor dari almanak lama.	2025-03-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
492	1	KKLP UKBI : pendampingan pelaksanaan UKBI secara daring kepada siswa di SMP Al Azhar Syifa Budi Parahyangan KBB (105 siswa)	Data diimpor dari almanak lama.	2025-03-18	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
493	1	Kunjungan Kerja Biro SDM Kemdikdasmen	Data diimpor dari almanak lama.	2025-03-18	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
494	1	Audiensi Ikatan Duta Bahasa Jawa Barat	Data diimpor dari almanak lama.	2025-03-18	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
495	1	KKLP UKBI : pendampingan pelaksanaan UKBI secara daring kepada siswa di SMAN 2 Lembang Kab. Bandung (310 siswa) dan Mahasiswa Universitas Kuningan (48 mahasiswa)	Data diimpor dari almanak lama.	2025-03-19	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
496	1	Rapat Persiapan Pembangunan ZI WBK	Data diimpor dari almanak lama.	2025-03-19	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
497	1	Agenda Kepala Balai: Fasilitasi Penelitian Mahasiswa Universitas Gadjah Mada	Data diimpor dari almanak lama.	2025-03-20	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
498	1	Rapat Program Humas dan Kerja Sama	Data diimpor dari almanak lama.	2025-03-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
499	1	Rapat Penyelarasan Tugas Jabatan Widyabasa	Data diimpor dari almanak lama.	2025-03-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
500	1	Rapat Penyusunan Rencana Kerja ZI WBK	Data diimpor dari almanak lama.	2025-03-24	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
501	1	Rapat Pengisian dan Pemenuhan Data Dukung ZI LKE	Data diimpor dari almanak lama.	2025-03-25	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
502	1	Agenda Kepala Balai: Audiensi Bersama Sekretaris Daerah Provinsi Jawa Barat	Data diimpor dari almanak lama.	2025-03-26	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 02:32:44	2025-08-25 02:32:44	\N	\N
503	1	tes ruangan	tes ruangan	2025-08-25	09:00:00	11:00:00	\N	Terpublikasi	2025-08-25 02:55:30	2025-08-25 02:55:30	\N	1
1610	1	Sosialisasi Pemilihan Pegawai Berprestasi dan Permendikdasmen Nomor 2 Tahun 2025	Data diimpor dari almanak lama.	2025-05-02	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1611	1	Apel Pagi	Data diimpor dari almanak lama.	2025-05-05	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1612	1	Siaran Pembinaan Bahasa Indonesia	Data diimpor dari almanak lama.	2025-05-05	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1613	1	Visitasi Itjen	Data diimpor dari almanak lama.	2025-05-05	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1614	1	Visitasi Itjen	Data diimpor dari almanak lama.	2025-05-06	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1615	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kabupaten Cirebon.	Data diimpor dari almanak lama.	2025-05-07	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1616	1	Visitasi Itjen	Data diimpor dari almanak lama.	2025-05-07	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1617	1	Sosialisasi Banpem Komlit (KKLP Literasi)	Data diimpor dari almanak lama.	2025-05-07	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1618	1	Sosialisasi Banpem Komsas (Pembahu)	Data diimpor dari almanak lama.	2025-05-07	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1619	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kabupaten Cirebon.	Data diimpor dari almanak lama.	2025-05-08	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1620	1	Visitasi Itjen	Data diimpor dari almanak lama.	2025-05-08	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1621	1	Dialog Penulisan dan Publikasi Sastra Daerah di Indonesia	Data diimpor dari almanak lama.	2025-05-09	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1622	1	Sosialisasi Budaya Pelayanan Prima	Data diimpor dari almanak lama.	2025-05-09	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1623	1	Rapat Koordinasi Pelaksanaan Revitalisasi Bahasa Daerah Antarpemangku Kepentingan di Provinsi Jawa Barat Tahun 2025	Data diimpor dari almanak lama.	2025-05-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1624	1	Sosialisasi UKBI Adaptif bagi Peserta PKBI (Zoom)	Data diimpor dari almanak lama.	2025-05-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1625	1	Bimtek PPID (Zaenal)	Data diimpor dari almanak lama.	2025-05-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1626	1	Rapat Koordinasi Pelaksanaan Revitalisasi Bahasa Daerah Antarpemangku Kepentingan di Provinsi Jawa Barat Tahun 2025	Data diimpor dari almanak lama.	2025-05-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1627	1	Diskusi tentang Pedoman Pengawasan Penggunaan Bahasa Indonesia	Data diimpor dari almanak lama.	2025-05-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1628	1	Bimtek PPID (Zaenal)	Data diimpor dari almanak lama.	2025-05-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1629	1	Rapat Koordinasi Pelaksanaan Revitalisasi Bahasa Daerah Antarpemangku Kepentingan di Provinsi Jawa Barat Tahun 2025	Data diimpor dari almanak lama.	2025-05-16	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1630	1	Bimtek PPID (Zaenal)	Data diimpor dari almanak lama.	2025-05-16	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1631	1	Apel pagi	Data diimpor dari almanak lama.	2025-05-19	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1632	1	KKLP KI: Pengambilan Data Tesaurus	Data diimpor dari almanak lama.	2025-05-19	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1633	1	Rapat KKLP	Data diimpor dari almanak lama.	2025-05-20	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1634	1	KKLP KI: Pengambilan Data Tesaurus	Data diimpor dari almanak lama.	2025-05-20	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1635	1	Koordinasi Juknis KKLP Literasi di Jakarta (Nandang)	Data diimpor dari almanak lama.	2025-05-20	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1636	1	KKLP KI: Pengambilan Data Tesaurus 2. Kunjungan Itjen (ZI-WBK)3. Koordinasi Juknis KKLP Literasi di Jakarta (Nandang) 4. DKT Implementasi Model Pembelajaran 5. KKLP UKBI: Pendampingan secara daring proses pelaksanaan UKBI Adaptif peerta PKBI Jabar	Data diimpor dari almanak lama.	2025-05-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1637	1	KKLP KI: Pengambilan Data Tesaurus	Data diimpor dari almanak lama.	2025-05-22	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1638	1	DKT Implementasi Model Pembelajaran	Data diimpor dari almanak lama.	2025-05-22	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1639	1	Koordinasi Juknis KKLP Literasi di Jakarta (Nandang)	Data diimpor dari almanak lama.	2025-05-22	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1640	1	KKLP KI: Pengambilan Data Tesaurus	Data diimpor dari almanak lama.	2025-05-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1641	1	DKT Implementasi Model Pembelajaran	Data diimpor dari almanak lama.	2025-05-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1642	1	KKLP UKBI: Pelaksanaan Kegiatan Pendampingan secara daring dalam proses pelaksanaan UKBI Adaptif kepada siswa SMAN 9 Bandung.	Data diimpor dari almanak lama.	2025-05-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1643	1	Koordinasi Juknis KKLP Literasi di Jakarta (Nandang)	Data diimpor dari almanak lama.	2025-05-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1644	1	IHT Pelayanan Prima (Desie dan Dul)	Data diimpor dari almanak lama.	2025-05-26	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1645	1	Penyusunan Bahan NSPK Duta Bahasa Tahun 2025 (Gempa)	Data diimpor dari almanak lama.	2025-05-26	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1646	1	Apel Senin	Data diimpor dari almanak lama.	2025-05-26	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1647	1	IHT Pelayanan Prima (Desie dan Dul)	Data diimpor dari almanak lama.	2025-05-27	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1648	1	Penyusunan Bahan NSPK Duta Bahasa Tahun 2025 (Gempa)	Data diimpor dari almanak lama.	2025-05-27	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1649	1	IHT Pelayanan Prima (Desie dan Dul)	Data diimpor dari almanak lama.	2025-05-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1650	1	Penyusunan Bahan NSPK Duta Bahasa Tahun 2025 (Gempa)	Data diimpor dari almanak lama.	2025-05-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1654	1	Audiensi dengan Ketua DPRD Kota Bandung	Data diimpor dari almanak lama.	2025-02-03	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1651	1	KKLP UKBI: Pelaksanaan Kegiatan Pendampingan secara daring dalam proses pelaksanaan UKBI Adaptif kepada siswa SMPIT Sinergi Islamic Kab. Bogor	Data diimpor dari almanak lama.	2025-05-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1652	1	Zoom Pemartabatan BI (Badan Bahasa)	Data diimpor dari almanak lama.	2025-05-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1653	1	Puncak Perayaan Hari Pendidikan Nasional Provinsi Jawa Barat (Kepala Balai)	Data diimpor dari almanak lama.	2025-05-28	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:47:08	2025-08-25 03:47:08	\N	\N
1655	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung	Data diimpor dari almanak lama.	2025-02-03	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1656	1	Rapat Penyelarasan Pedoman Pembinaan Lembaga	Data diimpor dari almanak lama.	2025-02-05	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1657	1	Rapat Anggaran dan Prognosis Triwulan I	Data diimpor dari almanak lama.	2025-02-06	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1658	1	Program Jaguar: Peningkatan Rohani Pegawai	Data diimpor dari almanak lama.	2025-02-07	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1659	1	1. Apel Pagi	Data diimpor dari almanak lama.	2025-02-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1660	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung	Data diimpor dari almanak lama.	2025-02-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1661	1	KKLP UKBI: Pendampingan secara daring pelaksanaan UKBI Adaptif kepada  siswa di SMA Islam Bhakti Asih Kabupaten Bandung (94 Siswa)	Data diimpor dari almanak lama.	2025-02-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1662	1	Kunjungan Kerja Universitas Muhammadiyah Bogor Raya	Data diimpor dari almanak lama.	2025-02-11	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1663	1	Asesmen Pejabat Administrator di Lingkungan Badan Bahasa	Data diimpor dari almanak lama.	2025-02-11	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1664	1	Agenda Kepala Balai: Asesmen Pejabat Administrator di Lingkungan Badan Bahasa	Data diimpor dari almanak lama.	2025-02-12	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1665	1	Agenda Kepala Balai:	Data diimpor dari almanak lama.	2025-02-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1666	1	Asesmen Pejabat Administrator di Lingkungan Badan Bahasa	Data diimpor dari almanak lama.	2025-02-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1667	1	Pendampingan Wakil Menteri Pendidikan dasar dan Menengah ke Kabupaten Garut	Data diimpor dari almanak lama.	2025-02-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1668	1	Agenda Kepala Balai:	Data diimpor dari almanak lama.	2025-02-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1669	1	Pendampingan Wakil Menteri Pendidikan dasar dan Menengah ke Kabupaten Garut	Data diimpor dari almanak lama.	2025-02-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1670	1	Program Jaguar: Tenis dan Bulutangkis bagi Pegawai	Data diimpor dari almanak lama.	2025-02-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1671	1	Agenda Kepala Balai:	Data diimpor dari almanak lama.	2025-02-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1672	1	Pendampingan Wakil Menteri Pendidikan dasar dan Menengah ke Kabupaten Garut	Data diimpor dari almanak lama.	2025-02-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1673	1	Apel Pagi	Data diimpor dari almanak lama.	2025-02-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1674	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung	Data diimpor dari almanak lama.	2025-02-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1675	1	KKLP Literasi: Festival Literasi Nasional dan Bursa Buku Murah di Kabupaten Bandung Barat	Data diimpor dari almanak lama.	2025-02-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1676	1	Rapat Koordinasi Penyelenggaraan Nama Rupabumi Tahun 2025 bersama Biro Pemerintah dan Otonomi Daerah Jawa Barat	Data diimpor dari almanak lama.	2025-02-18	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1677	1	Agenda Kepala Balai: Saresehan Bahasa Sunda sebagai Warisan Takbenda	Data diimpor dari almanak lama.	2025-02-19	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1678	1	KKLP UKBI: Pendampingan secara luring dalam  proses pelaksanaan UKBI Adaptif kepada  37 siswa di SMA Islam Cendekia Muda Bandung	Data diimpor dari almanak lama.	2025-02-20	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1679	1	Agenda Kepala Balai: Dina Basa Mimi Sejagat, DinasPendidikan dan Kebudayaan Kabupaten Indramayu	Data diimpor dari almanak lama.	2025-02-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1680	1	Program Jaguar: Tenis Meja dan Bulutangkis bagi Pegawai	Data diimpor dari almanak lama.	2025-02-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1681	1	Apel Pagi	Data diimpor dari almanak lama.	2025-02-24	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1682	1	Siaran Pembinaan Bahasa Indonesia di RRI Bandung	Data diimpor dari almanak lama.	2025-02-24	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1683	1	Agenda Kepala Balai: Pelantikan Pejabat Administrator dan Pengawas di Lingkungan Kemdikdasmen	Data diimpor dari almanak lama.	2025-02-24	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1684	1	Agenda Kepala Balai: Pelantikan Pejabat Administrator dan Pengawas di Lingkungan Kemdikdasmen	Data diimpor dari almanak lama.	2025-02-25	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1685	1	Program Jaguar: Munggahan dan Pelepasan Pegawai Balai Bahasa Provinsi Jawa Barat	Data diimpor dari almanak lama.	2025-02-26	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1686	1	Kunjungan Kerja Direktorat Pengamanan Objek Vital Polda Jabar	Data diimpor dari almanak lama.	2025-02-26	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1687	1	Sosialisasi Pola Kerja KDK dan KDM	Data diimpor dari almanak lama.	2025-02-27	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1688	1	Zoom: Tarhib Ramadan bersama Wakil Menteri Dikdasmen	Data diimpor dari almanak lama.	2025-02-27	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:27	2025-08-25 03:48:27	\N	\N
1689	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Bekasi.	Data diimpor dari almanak lama.	2025-06-02	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1690	1	Upacara Hari Kelahiran Pancasila	Data diimpor dari almanak lama.	2025-06-02	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1691	1	Penerimaan CPNS Balai Bahasa Provinsi Jawa Barat	Data diimpor dari almanak lama.	2025-06-02	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1692	1	Monitoring dan Evaluasi Penggunaan Anggaran Tahun 2025	Data diimpor dari almanak lama.	2025-06-02	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1693	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Bekasi.	Data diimpor dari almanak lama.	2025-06-03	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1694	1	Rapat Penyelarasan Program dan Anggaran	Data diimpor dari almanak lama.	2025-06-04	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1696	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Ciamis.	Data diimpor dari almanak lama.	2025-06-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1697	1	Audiensi dengan Pemkot Bandung	Data diimpor dari almanak lama.	2025-06-10	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1698	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Ciamis.	Data diimpor dari almanak lama.	2025-06-11	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1699	1	Pembekalan Finalis Duta Bahasa dan Pengumpulan Video Unjuk Bakat	Data diimpor dari almanak lama.	2025-06-12	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1700	1	ZOOM: Teknis Penyusunan Bahan Tayang untuk Penilaian Desk Evaluasi	Data diimpor dari almanak lama.	2025-06-12	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1701	1	Pembekalan Finalis Duta Bahasa	Data diimpor dari almanak lama.	2025-06-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1702	1	Sosialisasi Pelayanan Prima bagi pegawai BBPJB	Data diimpor dari almanak lama.	2025-06-13	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1703	1	Penjurian Unjuk Bakat Pildubas Jabar 2025	Data diimpor dari almanak lama.	2025-06-14	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1704	1	Psikotes dan Wawancara Duta Bahasa	Data diimpor dari almanak lama.	2025-06-15	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1705	1	Pelatihan Manajemen Risiko bagi pegawai BBPJB	Data diimpor dari almanak lama.	2025-06-16	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1706	1	Pildubas Jabar 2025: Psikotes, Uji Wicara Publik, Wawancara Kepribadian	Data diimpor dari almanak lama.	2025-06-16	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1707	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Majalengka.	Data diimpor dari almanak lama.	2025-06-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1708	1	Puma Seri IV: Guru SD Kab. Bogor	Data diimpor dari almanak lama.	2025-06-17	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1709	1	Puma Seri V: Guru SD Kab. Sukabumi	Data diimpor dari almanak lama.	2025-06-18	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1710	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Majalengka.	Data diimpor dari almanak lama.	2025-06-18	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1711	1	Puma Seri VI: Guru SD Kota Sukabumi	Data diimpor dari almanak lama.	2025-06-19	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1712	1	Final Duta Bahasa Jawa Barat	Data diimpor dari almanak lama.	2025-06-21	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1713	1	Bimbingan Teknis Pengajaran BIPA bagi Tenaga Pengajar dan Calon Tenaga Pengajar BIPA	Data diimpor dari almanak lama.	2025-06-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1714	1	Se-Kota Cirebon	Data diimpor dari almanak lama.	2025-06-23	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1715	1	audiensi dan koordinasi dengan pemangku kepentingan di	Data diimpor dari almanak lama.	2025-06-24	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1716	1	kabupaten majalengka	Data diimpor dari almanak lama.	2025-06-24	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1717	1	Visitasi Penguatan Pembangunan ZI WBK Biro OSDM Kemendikdasmen	Data diimpor dari almanak lama.	2025-06-25	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1718	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kab. Bandung.	Data diimpor dari almanak lama.	2025-06-26	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1719	1	KKLP UKBI: Pelaksanaan Kegiatan secara luring Koordinasi UKBI dengan pemangku Kepentingan di Instansi/Lembaga Pendidikan di Kab. Bandung.	Data diimpor dari almanak lama.	2025-06-27	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1720	1	Resepsi Milad Pondok Pesantren Aisyiyah	Data diimpor dari almanak lama.	2025-06-27	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1721	1	Serah-Terima mahasiswa magang Polban	Data diimpor dari almanak lama.	2025-06-30	08:00:00	16:00:00	\N	Terpublikasi	2025-08-25 03:48:50	2025-08-25 03:48:50	\N	\N
1722	1	Testing Share	Testing	2025-08-30	15:05:00	16:23:00	\N	Terpublikasi	2025-08-26 08:05:44	2025-08-26 08:06:17	2025-08-26 08:06:17	1
1723	36	contoh	uji coba	2025-08-26	15:00:00	16:00:00	agenda_files/910wTr7RJqD3xcpspQdPt0KVpOK7y0K6zBl3DJ8m.pdf	Terpublikasi	2025-08-26 08:05:52	2025-08-26 08:06:50	2025-08-26 08:06:50	2
1724	36	a	b	2025-08-27	07:00:00	08:00:00	agenda_files/qTCdgb2Mh6XuA1EAaj4qhw8hLgUTYOOOPk4iqz0O.pdf	Terpublikasi	2025-08-26 08:43:48	2025-08-26 08:44:18	2025-08-26 08:44:18	\N
1725	13	Bimtek Komlit Kab. Cirebon	Tim Kerja Literasi	2025-08-28	08:00:00	17:00:00	\N	Terpublikasi	2025-08-28 02:06:05	2025-08-28 02:06:05	\N	\N
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: daily_attendances; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.daily_attendances (id, ac_no, employee_name, date, check_in_time, check_out_time, status, notes, imported_by_user_id, created_at, updated_at) FROM stdin;
1	199204132019021006	Aef Saefullah, S.S.	2025-08-20	06:33:00	16:12:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
2	197403292006042001	ARIYANTI	2025-08-20	07:06:00	16:00:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
3	197611092003121002	Asep Rahmat Hidayat	2025-08-20	07:03:00	16:03:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
4	197109302003121002	Budijana, S.S.	2025-08-20	07:21:00	16:00:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
5	197604052005011001	Deni Setiawan, M.A.P.	2025-08-20	09:42:00	17:19:00	Terlambat	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
6	197612212005012001	Desie Natalia, S.S.	2025-08-20	07:19:00	16:03:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
7	197505212001121002	Dindin Samsudin, S.S.	2025-08-20	07:14:00	16:16:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
8	197710122001122005	Dr. Herawati, S.S.,M.A.	2025-08-20	07:04:00	17:15:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
9	196808161999032001	Dra. Sunarsih	2025-08-20	07:00:00	16:01:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
10	199306082020121005	Dudung Abdulah	2025-08-20	06:40:00	17:41:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
11	198108232002121003	Erwan Wibowo, S.Pd.	2025-08-20	07:08:00	16:02:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
12	198111072015042002	Ine Wahidiana, S.IP.	2025-08-20	07:30:00	16:04:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
13	197308052003122001	Kartika, S.S., M.Hum.	2025-08-20	07:26:00	16:20:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
14	197703122005011004	Mohamad Azhar Rasjid, S.S.	2025-08-20	06:39:00	16:27:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
15	196909152001121001	Mohammad Rizqi, S.S.	2025-08-20	06:49:00	16:11:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
16	200201092025062007	Nabila NUr Fitria, S.S.	2025-08-20	06:57:00	16:03:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
17	197704072006041002	Nandang Rudi Pamungkas	2025-08-20	07:22:00	17:36:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
18	199107172024212060	Nikita Daning Pratami, S.S.	2025-08-20	06:38:00	16:41:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
19	197407202006041001	Nondi Sopandi, S.Ag.	2025-08-20	06:59:00	16:27:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
20	197109222005011001	Siswanto, S.S.	2025-08-20	07:06:00	16:00:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
21	197808302006041002	Taufiq Awaludin, S.S.	2025-08-20	07:27:00	16:18:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
22	200106222025062012	Windy Fitra H, S.S.	2025-08-20	06:52:00	\N	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
23	199107072019021006	Zainal Arifin Nugraha	2025-08-20	07:02:00	16:37:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
24	197909032006041018	Asep Nono Hartono	2025-08-20	06:04:00	16:45:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
25	197502182005012001	Ita Nurvita, S.E.	2025-08-20	06:46:00	17:02:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
26	197706042005011002	Mamad Ahmad, S.Pd.	2025-08-20	06:56:00	16:03:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
27	198309152006041001	Mustajab	2025-08-20	07:44:00	16:37:00	Terlambat	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
28	198007082002121004	Setiawan	2025-08-20	07:18:00	16:53:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
29	197908202005012002	Susi Nuraliah, A.Md.	2025-08-20	06:41:00	17:20:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
30	198111032006042001	Vega Ihtiana Nurfarida, S.E.	2025-08-20	07:25:00	16:00:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
31	197809082003122001	Virta Fitriani, S.E.	2025-08-20	07:17:00	17:02:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
32	198208282010122005	Vita Luthfia Urfa, M.Hum.	2025-08-20	06:27:00	16:54:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
33	196911152003121002	Yanto	2025-08-20	07:01:00	17:17:00	Hadir	\N	36	2025-08-20 14:01:57	2025-08-20 14:01:57
\.


--
-- Data for Name: employee_works; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employee_works (id, user_id, year, month, title, description, file_path, file_type, created_at, updated_at, work_date) FROM stdin;
1	3	2025	8	tes	testing coi	public/hasil-kerja/2025/8/BzyjS4mv9f7Dt2M0xbHsKCZ5pL35Equqwuj5MrLh.pdf	pdf	2025-08-20 01:46:40	2025-08-20 01:46:40	\N
2	1	2025	8	Testing share localhost	Bukti testing	public/hasil-kerja/2025/8/0afm75QqQiQRIePONIlESv37RyniYFhcaxbNhJOg.jpg	jpg	2025-08-26 08:08:13	2025-08-26 08:08:13	\N
3	13	2025	8	Bimtek Komlit Kab	Timker Literasi	public/hasil-kerja/2025/8/oqAyz4Wlrd0rBaBMIaVtZgx9EIzUUbeot13NNo0o.jpg	jpg	2025-08-28 02:16:28	2025-08-28 02:16:28	\N
4	36	2025	8	Testing	\N	public/hasil-kerja/2025/8/JC3L273U2XAh0ISucsri6wzsyJyH5kcCmfDDIl4o.xlsx	xlsx	2025-08-28 03:26:33	2025-08-28 03:26:33	2025-08-28
6	36	2025	8	testing lagi	\N	public/hasil-kerja/2025/8/AdXUBzQxc74BYygy4czp2HZb1sv6j0wbSEETZHCu.pdf	pdf	2025-08-28 03:40:43	2025-08-28 03:40:43	2025-08-27
7	36	2025	8	testing lagi2	\N	public/hasil-kerja/2025/8/FAA9rCEORVH79a9k2sjsc1i4vzAurEKDwIEYtbn5.pdf	pdf	2025-08-28 03:41:06	2025-08-28 03:41:06	2025-08-29
8	36	2025	8	testing deskripsi	testing aja	public/hasil-kerja/2025/8/lkDKgjyswrcOqyXKApCOQGFaC8EYUyItc6zGaX64.pdf	pdf	2025-08-28 03:43:06	2025-08-28 03:43:06	2025-08-26
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: kinerja_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kinerja_details (id, kinerja_id, deskripsi_pekerjaan, realisasi_target, progres_kegiatan, kendala, strategi_penyelesaian, file_bukti, created_at, updated_at, pelaksana) FROM stdin;
\.


--
-- Data for Name: kinerjas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kinerjas (id, user_id, judul_kegiatan, target_kinerja, bulan_tahun, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: leave_records; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.leave_records (id, user_id, status, start_date, end_date, notes, created_at, updated_at) FROM stdin;
1	2	Cuti	2025-08-20	2025-08-24	\N	2025-08-20 14:23:41	2025-08-20 14:23:41
2	3	Cuti	2025-08-20	2025-08-21	\N	2025-08-20 14:37:57	2025-08-20 14:37:57
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_07_18_034914_create_agendas_table	1
5	2025_07_21_012610_create_daily_attendances_table	1
6	2025_07_22_021754_create_employee_works_table	1
7	2025_07_23_021900_create_leave_records_table	1
8	2025_07_28_035255_create_kinerja_table	1
9	2025_07_28_035314_create_kinerja_details_table	1
10	2025_07_30_045602_add_soft_deletes_to_agendas_table	1
11	2025_08_08_081748_create_rooms_table	1
12	2025_08_11_014021_add_room_id_to_agendas_table	1
13	2025_08_08_091352_add_pelaksana_to_kinerja_details_table	2
14	2025_08_28_031253_add_work_date_to_employee_works_table	3
\.


--
-- Data for Name: rooms; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.rooms (id, name, location, capacity, description, created_at, updated_at) FROM stdin;
1	Aula Tadjudin	Lantai 1	50	Aula serbaguna	2025-08-20 09:12:48	2025-08-20 09:12:48
2	Rapat	Lantai 2	20	Meja, TV	2025-08-25 02:52:02	2025-08-25 02:52:02
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, nip, email, birth_date, photo_path, role, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
2	AEF SAEFULLAH	199204132019021006	199204132019021006@bbpjb.test	1992-04-13	photos/pegawai/AEF_SAEFULLAH.png	pegawai	\N	$2y$12$g.hgPuFd3DAyiowu4x/qKeguMOe08aKnmguZ0JvTc3BkR6DcwXCZK	\N	2025-08-20 00:51:36	2025-08-20 00:51:36
3	AKHMAD SUSANTO	198002172005011002	198002172005011002@bbpjb.test	1980-02-17	photos/pegawai/AKHMAD_SUSANTO.png	pegawai	\N	$2y$12$lpIgT6zgoVo/Y5hUX47J2un91XMNaRANVfTYlL0n5AFhcMSclQ/t6	\N	2025-08-20 00:51:36	2025-08-20 00:51:36
4	ARIYANTI	197403292006042001	197403292006042001@bbpjb.test	1974-03-29	photos/pegawai/ARIYANTI.png	pegawai	\N	$2y$12$GuLOpeJ8FFmxLKt4SIaHVO4CHThOtDfko1I.XOrLkORaVDjSCI31S	\N	2025-08-20 00:51:37	2025-08-20 00:51:37
5	ASEP NONO HARTONO	197909032006041018	197909032006041018@bbpjb.test	1979-09-03	photos/pegawai/ASEP_NONO_HARTONO.png	pegawai	\N	$2y$12$srKHE3BMsiFl79Fgf.9mlOw4esdlSNjFDFrVddt2arsQplwhA3Cg6	\N	2025-08-20 00:51:37	2025-08-20 00:51:37
6	ASEP RAHMAT HIDAYAT	197611092003121002	197611092003121002@bbpjb.test	1976-11-09	photos/pegawai/ASEP_RAHMAT_HIDAYAT.png	pegawai	\N	$2y$12$ED3qjyGH32GM2xxHBODiIecB2xAe5u5/CkNi8MeCbyUmazzGL.J0W	\N	2025-08-20 00:51:38	2025-08-20 00:51:38
7	BUDIJANA	197109302003121002	197109302003121002@bbpjb.test	1971-09-30	photos/pegawai/BUDIJANA.png	pegawai	\N	$2y$12$Jm2Xlg46ea04HHtDAJDR/u0Zco2Obq4llXb.lcAzYDg9X1vZz6Gv2	\N	2025-08-20 00:51:39	2025-08-20 00:51:39
8	CUCU SUMINAR	197809012001122001	197809012001122001@bbpjb.test	1978-09-01	photos/pegawai/CUCU_SUMINAR.png	pegawai	\N	$2y$12$XkwfL1TsTK1S0kNHzSelCu4cR7WXW989X88t7OgRjZa3iB5AL5vi.	\N	2025-08-20 00:51:39	2025-08-20 00:51:39
9	DARMAN	198207212006041001	198207212006041001@bbpjb.test	1982-07-21	photos/pegawai/DARMAN.png	pegawai	\N	$2y$12$4YOtcyYyApo2RVJFu3loy.SvGt3yE6Y9cXhZC7Gh9oALXfpmWcfa2	\N	2025-08-20 00:51:40	2025-08-20 00:51:40
10	DENI SETIAWAN	197604052005011001	197604052005011001@bbpjb.test	1976-04-05	photos/pegawai/DENI_SETIAWAN.png	pegawai	\N	$2y$12$RaQlOpncPpzkIeG5E1j5ieBK2q8uAV9C1nX3zQ/K4rcfBXKAEMu.G	\N	2025-08-20 00:51:40	2025-08-20 00:51:40
11	DESIE NATALIA	197612212005012001	197612212005012001@bbpjb.test	1976-12-21	photos/pegawai/DESIE_NATALIA.png	pegawai	\N	$2y$12$3HzV2U5PwCkb9SoPdTz4m.vhu8yJhz5GItqAdNE00zFpSYhBsnM/6	\N	2025-08-20 00:51:41	2025-08-20 00:51:41
12	DINDIN SAMSUDIN	197505212001121002	197505212001121002@bbpjb.test	1975-05-21	photos/pegawai/DINDIN_SAMSUDIN.png	pegawai	\N	$2y$12$H07UI8hjKbQrvbdEQpUbmOn5k6LefQfeUeyNlojZRqMjGTThuhEaa	\N	2025-08-20 00:51:41	2025-08-20 00:51:41
13	DUDUNG ABDULAH	199306082020121005	199306082020121005@bbpjb.test	1993-06-08	photos/pegawai/DUDUNG_ABDULAH.png	pegawai	\N	$2y$12$EkVss9ZhEzYK1r2bnVTHZuPicHJTWMAmfB73sh1lO9.SW2VaIM/Ry	\N	2025-08-20 00:51:42	2025-08-20 00:51:42
14	ERWAN WIBOWO	198108232002121003	198108232002121003@bbpjb.test	1981-08-23	photos/pegawai/ERWAN_WIBOWO.png	pegawai	\N	$2y$12$65qNkVSEHrlL4N2ecmifiuGVdGTAl/uwF/AU61Em9JmB13atwUPD.	\N	2025-08-20 00:51:43	2025-08-20 00:51:43
15	HERAWATI	197710122001122005	197710122001122005@bbpjb.test	1977-10-12	photos/pegawai/HERAWATI.png	pegawai	\N	$2y$12$iStxa3EHMRN66f8HVxB2qupJZj1jW3O17fnFxe6p7h3YJ.9lmBRxq	\N	2025-08-20 00:51:43	2025-08-20 00:51:43
16	INE WAHIDIANA	198111072015042002	198111072015042002@bbpjb.test	1981-11-07	photos/pegawai/INE_WAHIDIANA.png	pegawai	\N	$2y$12$nLzw3cWDmd5oblsg33YzPeMSYNPd73iwb/THw3STqZ2/ThZ0PpEA6	\N	2025-08-20 00:51:44	2025-08-20 00:51:44
17	ITA NURVITA	197502182005012001	197502182005012001@bbpjb.test	1975-02-18	photos/pegawai/ITA_NURVITA.png	pegawai	\N	$2y$12$jvrv0Pd3krEJXXZIGyDOP.jSw2unu6lcp5b72I7k58b8XUNlk.DQC	\N	2025-08-20 00:51:44	2025-08-20 00:51:44
18	JUJUN HERLINA	197004262002122006	197004262002122006@bbpjb.test	1970-04-26	photos/pegawai/JUJUN_HERLINA.png	pegawai	\N	$2y$12$c1HkqXUlxwFc6HMuYffKP.AGEaiglggPESVuMYsw0rm9B/c10L0Ky	\N	2025-08-20 00:51:45	2025-08-20 00:51:45
19	KARTIKA	197308052003122001	197308052003122001@bbpjb.test	1973-08-05	photos/pegawai/KARTIKA.png	pegawai	\N	$2y$12$N9Srex5yzSouXenAKH8pyO/3M07I.9VbWHxOO5XVz7e30Fz/6AKYq	\N	2025-08-20 00:51:46	2025-08-20 00:51:46
20	LAILATUL MUNAWAROH	198003062002122002	198003062002122002@bbpjb.test	1980-03-06	photos/pegawai/LAILATUL_MUNAWAROH.png	pegawai	\N	$2y$12$qM9s7prPQBCwkvITCyN2WulTrtuTg6jefT.rptPWdEd/oMIE.NmKC	\N	2025-08-20 00:51:47	2025-08-20 00:51:47
21	LITA RIZKI FAUZIAH	199403092025062002	199403092025062002@bbpjb.test	1994-03-09	photos/pegawai/LITA_RIZKI_FAUZIAH.png	pegawai	\N	$2y$12$mZLiKR6ZylKOfJny0sxSMOV490/SuHefkKKyoWcsrrGq5YjzkZE62	\N	2025-08-20 00:51:48	2025-08-20 00:51:48
22	MAMAD AHMAD	197706042005011002	197706042005011002@bbpjb.test	1977-06-04	photos/pegawai/MAMAD_AHMAD.png	pegawai	\N	$2y$12$Nw9MEm/EhoXssok0zxGNAuwjbfSVGAHNGMABXDLOIbH8Y9onv7dsy	\N	2025-08-20 00:51:48	2025-08-20 00:51:48
23	MOHAMAD AZHAR RASJID	197703122005011004	197703122005011004@bbpjb.test	1977-03-12	photos/pegawai/MOHAMAD_AZHAR_RASJID.png	pegawai	\N	$2y$12$MXHrRLB8OX6rI7RgI7ErKOPjKG/BecK6pkZ/fFV0exHho2limeftW	\N	2025-08-20 00:51:49	2025-08-20 00:51:49
24	MOHAMMAD RIZQI	196909152001121001	196909152001121001@bbpjb.test	1969-09-15	photos/pegawai/MOHAMMAD_RIZQI.png	pegawai	\N	$2y$12$iiw2LDXaN8Jdne4Mg4NWWex2CKD/KDNhxI6D9iyXOm/wrYay7cDUm	\N	2025-08-20 00:51:49	2025-08-20 00:51:49
25	MUSTAJAB	198309152006041001	198309152006041001@bbpjb.test	1983-09-15	photos/pegawai/MUSTAJAB.png	pegawai	\N	$2y$12$NqiG/txACBzUTL/9arBDfuaJOXsXK277Rvla4fc7Vk3s07B3vEZJ.	\N	2025-08-20 00:51:50	2025-08-20 00:51:50
26	NABILA NUR FITRIA	200201092025062007	200201092025062007@bbpjb.test	2002-01-09	photos/pegawai/NABILA_NUR_FITRIA.png	pegawai	\N	$2y$12$0r8Ise.lzCH82EQIVIUrXOfNwu7uhybf6LF1g6QssgrMdMnkeD4RW	\N	2025-08-20 00:51:50	2025-08-20 00:51:50
27	NANDANG RUDI PAMUNGKAS	197704072006041002	197704072006041002@bbpjb.test	1977-04-07	photos/pegawai/NANDANG_RUDI_PAMUNGKAS.png	pegawai	\N	$2y$12$axWD1sPEC3TZV2mOE6x1o.SqjTFw4qtEa2opoBLgddQidLwEIMgBy	\N	2025-08-20 00:51:51	2025-08-20 00:51:51
28	NIKITA DANING PRATAMI	199107172024212060	199107172024212060@bbpjb.test	1991-07-17	photos/pegawai/NIKITA_DANING_PRATAMI.png	pegawai	\N	$2y$12$wWstSqB.7loq6ZC1IU.j3Onm5PlQrgf45MaLNYfBq.dxcBx.rRxf2	\N	2025-08-20 00:51:51	2025-08-20 00:51:51
29	NONDI SOPANDI	197407202006041001	197407202006041001@bbpjb.test	1974-07-20	photos/pegawai/NONDI_SOPANDI.png	pegawai	\N	$2y$12$ipw1wyfOZi6JEvHApBqnyO6ZTXtjLKqiX3YiqU3oU8jg0tLO/c8B2	\N	2025-08-20 00:51:52	2025-08-20 00:51:52
30	SETIAWAN	198007082002121004	198007082002121004@bbpjb.test	1980-07-08	photos/pegawai/SETIAWAN.png	pegawai	\N	$2y$12$7ukYi/dQ88mf3kiiJjnLbO04qL3EVG4BxO4jHNmhFZE/81jr74TdC	\N	2025-08-20 00:51:52	2025-08-20 00:51:52
31	SISWANTO	197109222005011001	197109222005011001@bbpjb.test	1971-09-22	photos/pegawai/SISWANTO.png	pegawai	\N	$2y$12$Dt1ixO9hgpjhDHAea77DiepNfNMf/5QvNZXjOxVHzG3Dd4oiHKyS.	\N	2025-08-20 00:51:53	2025-08-20 00:51:53
32	SULAEMAN	197302132002121001	197302132002121001@bbpjb.test	1973-02-13	photos/pegawai/SULAEMAN.png	pegawai	\N	$2y$12$NGJsTV0W8JEmE2Kwo0v.2.DTixzgAoDtaTVEQXrfhjRbadBt5VMAu	\N	2025-08-20 00:51:53	2025-08-20 00:51:53
33	SUNARSIH	196808161999032001	196808161999032001@bbpjb.test	1968-08-16	photos/pegawai/SUNARSIH.png	pegawai	\N	$2y$12$CeCGvqnTp2MWho2n5ybiM.MLEPgOIH07F/RddI4EAcPrDHgVA16Zm	\N	2025-08-20 00:51:54	2025-08-20 00:51:54
34	SUSI NURALIAH	197908202005012002	197908202005012002@bbpjb.test	1979-08-20	photos/pegawai/SUSI_NURALIAH.png	pegawai	\N	$2y$12$TOUWrpc.nrkS76RCDo4kbufqyUn1935nkn.8odfDIoOanAGQOcVR2	\N	2025-08-20 00:51:54	2025-08-20 00:51:54
1	Zidan Tri Satria Mukti	231511064	zidan3022@gmail.com	\N	\N	super_admin	\N	$2y$12$SaBttWBQK8VeHc5G8OYUhew8SSPKhvftEHmRuDX5/y7HsuHhzrasq	\N	2025-08-20 00:50:18	2025-08-27 03:16:49
35	TAUFIQ AWALUDIN	197808302006041002	197808302006041002@bbpjb.test	1978-08-30	photos/pegawai/TAUFIQ_AWALUDIN.png	pegawai	\N	$2y$12$vUl3lqW6zAeoj.rpx85FS.ULgULlBr/2ECzWFlyirr6ep1Vte/gli	\N	2025-08-20 00:51:55	2025-08-20 00:51:55
37	VIRTA FITRIANI	197809082003122001	197809082003122001@bbpjb.test	1978-09-08	photos/pegawai/VIRTA_FITRIANI.png	pegawai	\N	$2y$12$J7598o7woBewRVW87kOIPOSknxgFIJRzTRWyLSapQZkF.dCbN57Sy	\N	2025-08-20 00:51:56	2025-08-20 00:51:56
38	VITA LUTHFIA URFA	198208282010122005	198208282010122005@bbpjb.test	1982-08-28	photos/pegawai/VITA_LUTHFIA_URFA.png	pegawai	\N	$2y$12$7UIPnYUYRTeYCvMnG1s5seR/2fnv1vWTkJf9rvyvmw.M8VC1PWQ36	\N	2025-08-20 00:51:56	2025-08-20 00:51:56
39	WINDY FITRA H	200106222025062012	200106222025062012@bbpjb.test	2001-06-22	photos/pegawai/WINDY_FITRA_H.png	pegawai	\N	$2y$12$EKEG3Ft/ZfukI3YS.tUhFOcArUrjiK5s/YDyoaimzwuhjv6qktVhi	\N	2025-08-20 00:51:57	2025-08-20 00:51:57
40	YANTO	196911152003121002	196911152003121002@bbpjb.test	1969-11-15	photos/pegawai/YANTO.png	pegawai	\N	$2y$12$G7/fIc7RYXg8eroU2HK19ek7Q3gqWyYbEA.brbn3BXfm9D6YAD3LK	\N	2025-08-20 00:51:58	2025-08-20 00:51:58
41	ZAINAL ARIFIN NUGRAHA	199107072019021006	199107072019021006@bbpjb.test	1991-07-07	photos/pegawai/ZAINAL_ARIFIN_NUGRAHA.png	pegawai	\N	$2y$12$JOgEFGWrMKSFq8/i/5XAd.O/DqrFbY94eAmeobPxDXpTM3m28iuUG	\N	2025-08-20 00:51:58	2025-08-20 00:51:58
36	VEGA IHTIANA NURFARIDA	198111032006042001	198111032006042001@bbpjb.test	1981-11-03	photos/pegawai/VEGA_IHTIANA_NURFARIDA.png	super_admin	\N	$2y$12$MucK6VjUsxF9ljHt7dqSBeOncDZ/8GrvYB49T7tsLyzJ6k7cCKzbC	\N	2025-08-20 00:51:55	2025-08-20 00:51:55
\.


--
-- Name: agendas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.agendas_id_seq', 1725, true);


--
-- Name: daily_attendances_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.daily_attendances_id_seq', 33, true);


--
-- Name: employee_works_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.employee_works_id_seq', 8, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: kinerja_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kinerja_details_id_seq', 1, true);


--
-- Name: kinerjas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kinerjas_id_seq', 2, true);


--
-- Name: leave_records_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.leave_records_id_seq', 2, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 14, true);


--
-- Name: rooms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rooms_id_seq', 2, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 41, true);


--
-- Name: agendas agendas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agendas
    ADD CONSTRAINT agendas_pkey PRIMARY KEY (id);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: daily_attendances daily_attendances_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.daily_attendances
    ADD CONSTRAINT daily_attendances_pkey PRIMARY KEY (id);


--
-- Name: employee_works employee_works_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_works
    ADD CONSTRAINT employee_works_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: kinerja_details kinerja_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kinerja_details
    ADD CONSTRAINT kinerja_details_pkey PRIMARY KEY (id);


--
-- Name: kinerjas kinerjas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kinerjas
    ADD CONSTRAINT kinerjas_pkey PRIMARY KEY (id);


--
-- Name: leave_records leave_records_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leave_records
    ADD CONSTRAINT leave_records_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: rooms rooms_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT rooms_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_nip_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_nip_unique UNIQUE (nip);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: agendas agendas_room_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agendas
    ADD CONSTRAINT agendas_room_id_foreign FOREIGN KEY (room_id) REFERENCES public.rooms(id) ON DELETE SET NULL;


--
-- Name: agendas agendas_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agendas
    ADD CONSTRAINT agendas_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: daily_attendances daily_attendances_imported_by_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.daily_attendances
    ADD CONSTRAINT daily_attendances_imported_by_user_id_foreign FOREIGN KEY (imported_by_user_id) REFERENCES public.users(id);


--
-- Name: employee_works employee_works_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_works
    ADD CONSTRAINT employee_works_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: kinerja_details kinerja_details_kinerja_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kinerja_details
    ADD CONSTRAINT kinerja_details_kinerja_id_foreign FOREIGN KEY (kinerja_id) REFERENCES public.kinerjas(id) ON DELETE CASCADE;


--
-- Name: kinerjas kinerjas_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kinerjas
    ADD CONSTRAINT kinerjas_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: leave_records leave_records_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leave_records
    ADD CONSTRAINT leave_records_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

