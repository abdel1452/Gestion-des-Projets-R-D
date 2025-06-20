--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5 (Debian 17.5-1.pgdg120+1)
-- Dumped by pg_dump version 17.5 (Debian 17.5-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: notify_messenger_messages(); Type: FUNCTION; Schema: public; Owner: a.elidrissi
--

CREATE FUNCTION public.notify_messenger_messages() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    BEGIN
        PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
        RETURN NEW;
    END;
$$;


ALTER FUNCTION public.notify_messenger_messages() OWNER TO "a.elidrissi";

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: a.elidrissi
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO "a.elidrissi";

--
-- Name: messenger_messages; Type: TABLE; Schema: public; Owner: a.elidrissi
--

CREATE TABLE public.messenger_messages (
    id bigint NOT NULL,
    body text NOT NULL,
    headers text NOT NULL,
    queue_name character varying(190) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    available_at timestamp(0) without time zone NOT NULL,
    delivered_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.messenger_messages OWNER TO "a.elidrissi";

--
-- Name: COLUMN messenger_messages.created_at; Type: COMMENT; Schema: public; Owner: a.elidrissi
--

COMMENT ON COLUMN public.messenger_messages.created_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN messenger_messages.available_at; Type: COMMENT; Schema: public; Owner: a.elidrissi
--

COMMENT ON COLUMN public.messenger_messages.available_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN messenger_messages.delivered_at; Type: COMMENT; Schema: public; Owner: a.elidrissi
--

COMMENT ON COLUMN public.messenger_messages.delivered_at IS '(DC2Type:datetime_immutable)';


--
-- Name: messenger_messages_id_seq; Type: SEQUENCE; Schema: public; Owner: a.elidrissi
--

CREATE SEQUENCE public.messenger_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.messenger_messages_id_seq OWNER TO "a.elidrissi";

--
-- Name: messenger_messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: a.elidrissi
--

ALTER SEQUENCE public.messenger_messages_id_seq OWNED BY public.messenger_messages.id;


--
-- Name: project; Type: TABLE; Schema: public; Owner: a.elidrissi
--

CREATE TABLE public.project (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    description text NOT NULL,
    image_filename character varying(255) DEFAULT NULL::character varying,
    prod_url character varying(255),
    preprod_url character varying(255)
);


ALTER TABLE public.project OWNER TO "a.elidrissi";

--
-- Name: project_id_seq; Type: SEQUENCE; Schema: public; Owner: a.elidrissi
--

CREATE SEQUENCE public.project_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.project_id_seq OWNER TO "a.elidrissi";

--
-- Name: project_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: a.elidrissi
--

ALTER SEQUENCE public.project_id_seq OWNED BY public.project.id;


--
-- Name: project_sorted; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.project_sorted AS
 SELECT id,
    name,
    description,
    image_filename,
    prod_url,
    preprod_url
   FROM public.project
  ORDER BY id;


ALTER VIEW public.project_sorted OWNER TO postgres;

--
-- Name: register; Type: TABLE; Schema: public; Owner: a.elidrissi
--

CREATE TABLE public.register (
    id integer NOT NULL,
    username character varying(180) NOT NULL,
    password character varying(255) NOT NULL,
    roles jsonb NOT NULL
);


ALTER TABLE public.register OWNER TO "a.elidrissi";

--
-- Name: register_id_seq; Type: SEQUENCE; Schema: public; Owner: a.elidrissi
--

CREATE SEQUENCE public.register_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.register_id_seq OWNER TO "a.elidrissi";

--
-- Name: register_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: a.elidrissi
--

ALTER SEQUENCE public.register_id_seq OWNED BY public.register.id;


--
-- Name: sorted_projects; Type: MATERIALIZED VIEW; Schema: public; Owner: postgres
--

CREATE MATERIALIZED VIEW public.sorted_projects AS
 SELECT id,
    name,
    description,
    image_filename,
    prod_url,
    preprod_url
   FROM public.project
  ORDER BY id
  WITH NO DATA;


ALTER MATERIALIZED VIEW public.sorted_projects OWNER TO postgres;

--
-- Name: messenger_messages id; Type: DEFAULT; Schema: public; Owner: a.elidrissi
--

ALTER TABLE ONLY public.messenger_messages ALTER COLUMN id SET DEFAULT nextval('public.messenger_messages_id_seq'::regclass);


--
-- Name: project id; Type: DEFAULT; Schema: public; Owner: a.elidrissi
--

ALTER TABLE ONLY public.project ALTER COLUMN id SET DEFAULT nextval('public.project_id_seq'::regclass);


--
-- Name: register id; Type: DEFAULT; Schema: public; Owner: a.elidrissi
--

ALTER TABLE ONLY public.register ALTER COLUMN id SET DEFAULT nextval('public.register_id_seq'::regclass);


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: a.elidrissi
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20250606145416	2025-06-06 16:56:36	13
DoctrineMigrations\\Version20250610085309	2025-06-10 10:53:24	39
DoctrineMigrations\\Version20250611092220	2025-06-11 11:22:27	13
DoctrineMigrations\\Version20250612132754	2025-06-12 15:30:25	29
DoctrineMigrations\\Version20250612132955	2025-06-16 11:33:50	23
DoctrineMigrations\\Version20250616092443	2025-06-16 11:33:50	9
DoctrineMigrations\\Version20250618084639	2025-06-18 10:47:14	32
\.


--
-- Data for Name: messenger_messages; Type: TABLE DATA; Schema: public; Owner: a.elidrissi
--

COPY public.messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) FROM stdin;
\.


--
-- Data for Name: project; Type: TABLE DATA; Schema: public; Owner: a.elidrissi
--

COPY public.project (id, name, description, image_filename, prod_url, preprod_url) FROM stdin;
7	9060 - Cally	Application de centre d'appels et support client (version historique)	Cally.jpg	https://10.10.0.44:9061/	http://10.10.0.44:9220/login?id=10axtu
8	9070 - Volly	Système de gestion logistique et planification des interventions	Volly.jpg	https://10.10.0.44:9071/	http://10.10.0.44:9070/home
9	9080 - AmsomEtMoi-EspaceClient	Espace client dédié aux résidents pour la gestion de leur logement	Amsom&Moi.jpg	\N	http://10.10.0.44:9080/login
10	9090 - ApiMetier	API principale regroupant les services métiers de l'écosystème	\N	https://10.10.0.44:9091/	http://10.10.0.44:9090/
11	9110 - ApiMailing	Service d'envoi et de gestion des campagnes emailing	\N	\N	http://10.10.0.44:9110/
12	9120 - ApiLocataire	API de gestion centralisée des dossiers locataires	\N	https://10.10.0.44:9121/	http://10.10.0.44:9120/
13	9130 - Oscar	Outil de suivi des performances et indicateurs clés	Oscar.jpg	\N	http://10.10.0.44:9130/
27	9270 - ComCible-Notify	Système de notifications ciblées par canaux	ComCible-Notify.jpg	\N	http://10.10.0.44:9270/login
15	9150 - ApiAuth	Service centralisé d'authentification et SSO	\N	https://10.10.0.44:9151/	http://10.10.0.44:9150/
28	9300 - RechercheTiers	Annuaire unifié des partenaires et intervenants	RechercheTiers.jpg	\N	http://10.10.0.44:9300/
29	9320 - SuiviCo	Plateforme de suivi des contentieux juridiques	SuiviCo.jpg	\N	http://10.10.0.44:9320/login
14	9140 - Suivi-Recla	Plateforme de traitement des réclamations clients	default-project.png	\N	http://10.10.0.44:9140/
16	9160 - ApiFournisseur	API d'intégration avec les systèmes fournisseurs	\N	\N	http://10.10.0.44:9160/
17	9170 - ApiGed	Gestion électronique de documents et archivage	\N	\N	http://10.10.0.44:9170/
18	9180 - VeilleSecuritaire	Tableau de bord de monitoring des incidents sécurité	veillesecuritaire.jpg	\N	http://10.10.0.44:9180/login?id=p63c2m/
1	9000 - AmsomBootstrap	Framework interne de composants Bootstrap pour le développement rapide d'applications	AmsomBootstrap.jpg	\N	http://10.10.0.44:9000/
19	9190 - Patri 	Application de gestion du patrimoine immobilier	Patri.jpg	\N	http://10.10.0.44:9190/login?id=ykkepu
20	9200 - FicheProprete 	Gestion des états des lieux et nettoyages	\N	\N	http://10.10.0.44:9200/
21	9210 - Kifekoi 	Outil de reporting et business intelligence	Kifekoi.jpg	\N	http://10.10.0.44:9220/login?id=ifo40g
22	9220 - Cockpit 	Tableau de bord opérationnel pour la direction	cockpit2.jpg	\N	http://10.10.0.44:9220/login?id=ifo40g
23	9230 - ApiTraduction 	Service multilingue pour la traduction de contenus	\N	\N	http://10.10.0.44:9230/
24	9240 - ApiDocument	Génération automatisée de documents contractuels	\N	\N	http://10.10.0.44:9240/
25	9250 - NouvellesFiches	Module de création et gestion des fiches techniques	NouvellesFiches.jpg	\N	http://10.10.0.44:9250/login?id=0fsczf
2	9010 - Extranet-Fournisseur	Portail extranet pour la gestion des fournisseurs partenaires	Extranet-Fournisseur.jpg	\N	http://10.10.0.44:9010/login
3	9020 - Sézame-Admin	Console d'administration centralisée des accès et permissions utilisateurs	Sézam.jpg	\N	http://10.10.0.44:9020/login?id=ccsn3
4	9030 - Loky	Plateforme de suivi des projets immobiliers et gestion de chantier	Loky.jpg	\N	http://10.10.0.44:9030/
5	9040 - Projimmo-Bricks	Outil de suivi des projets immobiliers	Bricks.jpg	https://10.10.0.44:9041/	http://10.10.0.44:9040/login
6	9050 - Trouve-Ton-Marche	Outil d'analyse et de matching commercial pour les biens disponibles	TTM.jpg	\N	http://10.10.0.44:9050/
26	9260 - CallyV2	Nouvelle version du centre de relations clients	CallyV2.jpg	\N	https://cockpit-preprod.amsom-habitat.fr/
\.


--
-- Data for Name: register; Type: TABLE DATA; Schema: public; Owner: a.elidrissi
--

COPY public.register (id, username, password, roles) FROM stdin;
10	root	$2y$13$DV5s28Z5gUxzvjytXnpfDOssfytIYt/fwIHpsVQv5ZoF5BCcryfyW	["ROLE_ADMIN"]
13	root2	$2y$13$h/e8Jo3Fd4EP8xiRfLr.dOZTKHjINgxZXH59fJU7OPqjcfNVU4yRe	["ROLE_ADMIN"]
\.


--
-- Name: messenger_messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: a.elidrissi
--

SELECT pg_catalog.setval('public.messenger_messages_id_seq', 1, false);


--
-- Name: project_id_seq; Type: SEQUENCE SET; Schema: public; Owner: a.elidrissi
--

SELECT pg_catalog.setval('public.project_id_seq', 47, true);


--
-- Name: register_id_seq; Type: SEQUENCE SET; Schema: public; Owner: a.elidrissi
--

SELECT pg_catalog.setval('public.register_id_seq', 13, true);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: a.elidrissi
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: messenger_messages messenger_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: a.elidrissi
--

ALTER TABLE ONLY public.messenger_messages
    ADD CONSTRAINT messenger_messages_pkey PRIMARY KEY (id);


--
-- Name: project project_pkey; Type: CONSTRAINT; Schema: public; Owner: a.elidrissi
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT project_pkey PRIMARY KEY (id);

ALTER TABLE public.project CLUSTER ON project_pkey;


--
-- Name: register register_pkey; Type: CONSTRAINT; Schema: public; Owner: a.elidrissi
--

ALTER TABLE ONLY public.register
    ADD CONSTRAINT register_pkey PRIMARY KEY (id);


--
-- Name: idx_75ea56e016ba31db; Type: INDEX; Schema: public; Owner: a.elidrissi
--

CREATE INDEX idx_75ea56e016ba31db ON public.messenger_messages USING btree (delivered_at);


--
-- Name: idx_75ea56e0e3bd61ce; Type: INDEX; Schema: public; Owner: a.elidrissi
--

CREATE INDEX idx_75ea56e0e3bd61ce ON public.messenger_messages USING btree (available_at);


--
-- Name: idx_75ea56e0fb7336f0; Type: INDEX; Schema: public; Owner: a.elidrissi
--

CREATE INDEX idx_75ea56e0fb7336f0 ON public.messenger_messages USING btree (queue_name);


--
-- Name: idx_sorted_projects_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_sorted_projects_id ON public.sorted_projects USING btree (id);


--
-- Name: uniq_5ff94014f85e0677; Type: INDEX; Schema: public; Owner: a.elidrissi
--

CREATE UNIQUE INDEX uniq_5ff94014f85e0677 ON public.register USING btree (username);


--
-- Name: messenger_messages notify_trigger; Type: TRIGGER; Schema: public; Owner: a.elidrissi
--

CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON public.messenger_messages FOR EACH ROW EXECUTE FUNCTION public.notify_messenger_messages();


--
-- Name: sorted_projects; Type: MATERIALIZED VIEW DATA; Schema: public; Owner: postgres
--

REFRESH MATERIALIZED VIEW public.sorted_projects;


--
-- PostgreSQL database dump complete
--

