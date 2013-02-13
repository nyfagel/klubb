--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.7
-- Dumped by pg_dump version 9.2.2
-- Started on 2013-02-13 11:49:27 CET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

DROP DATABASE klubb;
--
-- TOC entry 2061 (class 1262 OID 16581)
-- Name: klubb; Type: DATABASE; Schema: -; Owner: klubb
--

CREATE DATABASE klubb WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'sv_SE.UTF-8' LC_CTYPE = 'sv_SE.UTF-8';


ALTER DATABASE klubb OWNER TO klubb;

\connect klubb

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 2062 (class 1262 OID 16581)
-- Dependencies: 2061
-- Name: klubb; Type: COMMENT; Schema: -; Owner: klubb
--

COMMENT ON DATABASE klubb IS 'Database for the local installation of Klubb.';


--
-- TOC entry 6 (class 2615 OID 2200)
-- Name: klubb; Type: SCHEMA; Schema: -; Owner: klubb
--

CREATE SCHEMA klubb;


ALTER SCHEMA klubb OWNER TO klubb;

--
-- TOC entry 2063 (class 0 OID 0)
-- Dependencies: 6
-- Name: SCHEMA klubb; Type: COMMENT; Schema: -; Owner: klubb
--

COMMENT ON SCHEMA klubb IS 'Default schema for Klubb.';


--
-- TOC entry 190 (class 3079 OID 11656)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2065 (class 0 OID 0)
-- Dependencies: 190
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = klubb, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 161 (class 1259 OID 16582)
-- Name: authentication; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE authentication (
    "user" integer NOT NULL,
    series character varying(255) NOT NULL,
    key character varying(255) NOT NULL,
    created integer NOT NULL
);


ALTER TABLE klubb.authentication OWNER TO klubb;

--
-- TOC entry 164 (class 1259 OID 16617)
-- Name: ci_sessions; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE ci_sessions (
    session_id character varying(40) DEFAULT '0'::character varying NOT NULL,
    ip_address character varying(45) DEFAULT '0'::character varying NOT NULL,
    user_agent character varying(120) NOT NULL,
    last_activity integer DEFAULT 0 NOT NULL,
    user_data text NOT NULL
);


ALTER TABLE klubb.ci_sessions OWNER TO klubb;

--
-- TOC entry 182 (class 1259 OID 16774)
-- Name: keys; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE keys (
    id integer NOT NULL,
    key character varying(40) NOT NULL,
    level smallint NOT NULL,
    ignore_limits boolean DEFAULT false NOT NULL,
    is_private_key boolean DEFAULT false NOT NULL,
    ip_addresses text,
    date_created integer NOT NULL
);


ALTER TABLE klubb.keys OWNER TO klubb;

--
-- TOC entry 181 (class 1259 OID 16772)
-- Name: keys_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE keys_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.keys_id_seq OWNER TO klubb;

--
-- TOC entry 2066 (class 0 OID 0)
-- Dependencies: 181
-- Name: keys_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE keys_id_seq OWNED BY keys.id;


--
-- TOC entry 186 (class 1259 OID 16798)
-- Name: limits; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE limits (
    id integer NOT NULL,
    uri character varying(255) NOT NULL,
    count integer NOT NULL,
    hour_started integer NOT NULL,
    api_key character varying(40) NOT NULL
);


ALTER TABLE klubb.limits OWNER TO klubb;

--
-- TOC entry 185 (class 1259 OID 16796)
-- Name: limits_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE limits_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.limits_id_seq OWNER TO klubb;

--
-- TOC entry 2067 (class 0 OID 0)
-- Dependencies: 185
-- Name: limits_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE limits_id_seq OWNED BY limits.id;


--
-- TOC entry 166 (class 1259 OID 16630)
-- Name: log; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE log (
    id integer NOT NULL,
    "user" integer,
    action character varying(45) NOT NULL,
    path character varying(100),
    "time" timestamp with time zone NOT NULL
);


ALTER TABLE klubb.log OWNER TO klubb;

--
-- TOC entry 165 (class 1259 OID 16628)
-- Name: log_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.log_id_seq OWNER TO klubb;

--
-- TOC entry 2068 (class 0 OID 0)
-- Dependencies: 165
-- Name: log_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE log_id_seq OWNED BY log.id;


--
-- TOC entry 184 (class 1259 OID 16787)
-- Name: logs; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE logs (
    id integer NOT NULL,
    uri character varying(255) NOT NULL,
    method character varying(6) NOT NULL,
    params text,
    api_key character varying(40) NOT NULL,
    ip_address character varying(45) NOT NULL,
    "time" integer NOT NULL,
    authorized boolean NOT NULL
);


ALTER TABLE klubb.logs OWNER TO klubb;

--
-- TOC entry 183 (class 1259 OID 16785)
-- Name: logs_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.logs_id_seq OWNER TO klubb;

--
-- TOC entry 2069 (class 0 OID 0)
-- Dependencies: 183
-- Name: logs_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE logs_id_seq OWNED BY logs.id;


--
-- TOC entry 168 (class 1259 OID 16653)
-- Name: member_data; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE member_data (
    id integer NOT NULL,
    notes text,
    inactive boolean DEFAULT false,
    inactive_date date
);


ALTER TABLE klubb.member_data OWNER TO klubb;

--
-- TOC entry 167 (class 1259 OID 16651)
-- Name: member_data_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE member_data_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.member_data_id_seq OWNER TO klubb;

--
-- TOC entry 2070 (class 0 OID 0)
-- Dependencies: 167
-- Name: member_data_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE member_data_id_seq OWNED BY member_data.id;


--
-- TOC entry 188 (class 1259 OID 25557)
-- Name: member_flags; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE member_flags (
    key character varying(45) NOT NULL,
    "desc" character varying(100) NOT NULL,
    id integer NOT NULL
);


ALTER TABLE klubb.member_flags OWNER TO klubb;

--
-- TOC entry 187 (class 1259 OID 25555)
-- Name: member_flags_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE member_flags_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.member_flags_id_seq OWNER TO klubb;

--
-- TOC entry 2071 (class 0 OID 0)
-- Dependencies: 187
-- Name: member_flags_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE member_flags_id_seq OWNED BY member_flags.id;


--
-- TOC entry 170 (class 1259 OID 16665)
-- Name: members; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE members (
    id integer NOT NULL,
    type integer,
    firstname character varying(45) NOT NULL,
    lastname character varying(45) NOT NULL,
    ssid character varying(12) NOT NULL,
    phone character varying(12) NOT NULL,
    address character varying(45),
    zip character varying(10),
    city character varying(45),
    data integer,
    email character varying(100),
    last_update timestamp with time zone
);


ALTER TABLE klubb.members OWNER TO klubb;

--
-- TOC entry 169 (class 1259 OID 16663)
-- Name: members_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE members_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.members_id_seq OWNER TO klubb;

--
-- TOC entry 2072 (class 0 OID 0)
-- Dependencies: 169
-- Name: members_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE members_id_seq OWNED BY members.id;


--
-- TOC entry 180 (class 1259 OID 16763)
-- Name: migrations; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE migrations (
    version integer NOT NULL
);


ALTER TABLE klubb.migrations OWNER TO klubb;

--
-- TOC entry 172 (class 1259 OID 16678)
-- Name: rights; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE rights (
    id integer NOT NULL,
    role integer NOT NULL,
    add_members boolean DEFAULT false NOT NULL,
    add_users boolean DEFAULT false NOT NULL,
    use_system boolean DEFAULT true NOT NULL
);


ALTER TABLE klubb.rights OWNER TO klubb;

--
-- TOC entry 171 (class 1259 OID 16676)
-- Name: rights_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE rights_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.rights_id_seq OWNER TO klubb;

--
-- TOC entry 2073 (class 0 OID 0)
-- Dependencies: 171
-- Name: rights_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE rights_id_seq OWNED BY rights.id;


--
-- TOC entry 174 (class 1259 OID 16695)
-- Name: roles; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE roles (
    id integer NOT NULL,
    name character varying(45) NOT NULL,
    system boolean DEFAULT true NOT NULL
);


ALTER TABLE klubb.roles OWNER TO klubb;

--
-- TOC entry 179 (class 1259 OID 16754)
-- Name: role_view; Type: VIEW; Schema: klubb; Owner: klubb
--

CREATE VIEW role_view AS
    SELECT roles.id, rights.add_members, rights.add_users, rights.use_system, roles.name, roles.system AS system_role FROM roles, rights WHERE (roles.id = rights.role);


ALTER TABLE klubb.role_view OWNER TO klubb;

--
-- TOC entry 173 (class 1259 OID 16693)
-- Name: roles_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.roles_id_seq OWNER TO klubb;

--
-- TOC entry 2074 (class 0 OID 0)
-- Dependencies: 173
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE roles_id_seq OWNED BY roles.id;


--
-- TOC entry 175 (class 1259 OID 16704)
-- Name: system; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE system (
    key character varying(45) NOT NULL,
    value character varying(255) NOT NULL
);


ALTER TABLE klubb.system OWNER TO klubb;

--
-- TOC entry 177 (class 1259 OID 16711)
-- Name: types; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE types (
    id integer NOT NULL,
    name character varying(45) NOT NULL,
    plural character varying(45),
    "desc" character varying(65)
);


ALTER TABLE klubb.types OWNER TO klubb;

--
-- TOC entry 176 (class 1259 OID 16709)
-- Name: types_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.types_id_seq OWNER TO klubb;

--
-- TOC entry 2075 (class 0 OID 0)
-- Dependencies: 176
-- Name: types_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE types_id_seq OWNED BY types.id;


--
-- TOC entry 189 (class 1259 OID 25565)
-- Name: types_requirements; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE types_requirements (
    fieldname character varying(45) NOT NULL,
    type integer NOT NULL,
    fieldtype character varying(45) NOT NULL,
    rule character varying(45) NOT NULL,
    rule_desc character varying(45) NOT NULL
);


ALTER TABLE klubb.types_requirements OWNER TO klubb;

--
-- TOC entry 178 (class 1259 OID 16739)
-- Name: user_role; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE user_role (
    "user" integer NOT NULL,
    role integer NOT NULL
);


ALTER TABLE klubb.user_role OWNER TO klubb;

--
-- TOC entry 163 (class 1259 OID 16594)
-- Name: users; Type: TABLE; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    firstname character varying(100),
    lastname character varying(100),
    email character varying(255) NOT NULL,
    phone character varying(12),
    key character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    registered integer NOT NULL,
    first_login boolean DEFAULT true NOT NULL,
    loggedin boolean DEFAULT false NOT NULL
);


ALTER TABLE klubb.users OWNER TO klubb;

--
-- TOC entry 162 (class 1259 OID 16592)
-- Name: users_id_seq; Type: SEQUENCE; Schema: klubb; Owner: klubb
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE klubb.users_id_seq OWNER TO klubb;

--
-- TOC entry 2076 (class 0 OID 0)
-- Dependencies: 162
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: klubb; Owner: klubb
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- TOC entry 1975 (class 2604 OID 16777)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY keys ALTER COLUMN id SET DEFAULT nextval('keys_id_seq'::regclass);


--
-- TOC entry 1979 (class 2604 OID 16801)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY limits ALTER COLUMN id SET DEFAULT nextval('limits_id_seq'::regclass);


--
-- TOC entry 1964 (class 2604 OID 16633)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY log ALTER COLUMN id SET DEFAULT nextval('log_id_seq'::regclass);


--
-- TOC entry 1978 (class 2604 OID 16790)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY logs ALTER COLUMN id SET DEFAULT nextval('logs_id_seq'::regclass);


--
-- TOC entry 1965 (class 2604 OID 16656)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY member_data ALTER COLUMN id SET DEFAULT nextval('member_data_id_seq'::regclass);


--
-- TOC entry 1980 (class 2604 OID 25560)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY member_flags ALTER COLUMN id SET DEFAULT nextval('member_flags_id_seq'::regclass);


--
-- TOC entry 1967 (class 2604 OID 16668)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY members ALTER COLUMN id SET DEFAULT nextval('members_id_seq'::regclass);


--
-- TOC entry 1968 (class 2604 OID 16681)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY rights ALTER COLUMN id SET DEFAULT nextval('rights_id_seq'::regclass);


--
-- TOC entry 1972 (class 2604 OID 16698)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY roles ALTER COLUMN id SET DEFAULT nextval('roles_id_seq'::regclass);


--
-- TOC entry 1974 (class 2604 OID 16714)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY types ALTER COLUMN id SET DEFAULT nextval('types_id_seq'::regclass);


--
-- TOC entry 1958 (class 2604 OID 16597)
-- Name: id; Type: DEFAULT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- TOC entry 2029 (class 0 OID 16582)
-- Dependencies: 161
-- Data for Name: authentication; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO authentication ("user", series, key, created) VALUES (1, '4ccb70112beaf58c1949f2fd7c91d0a79e6b7becb7176f3eebb9ec7ee706226e', '348667ae44427f3d91a56a98246000687c92db5e422117cb0f14bf3d9fd88a7b', 1360589304);
INSERT INTO authentication ("user", series, key, created) VALUES (1, '4c712c00cd77ab35d7085509933cf1a40e8871c19edef7f71983f5065f82fa29', '897d951703d88b603bfa3c98b038ef19177d2f52e07f3420e1857cc16a9bc216', 1360745827);
INSERT INTO authentication ("user", series, key, created) VALUES (1, 'fd6d31e54be43230d5791627818356e247aa0e4c492396af681fb741a52c5fbb', 'c095076670143308ae435fbff05ba0383b8cff825ab49db28cc8648df031fceb', 1360750883);


--
-- TOC entry 2032 (class 0 OID 16617)
-- Dependencies: 164
-- Data for Name: ci_sessions; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5b962141938bb2abb35c0f06be5d0d22', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360747961, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('18b1e09c6c7e8e23b5f5ff5ed8ffa047', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360748012, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('1def802cd14a337b62b541a07ed9ee48', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750789, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('83fab4a77812758cbbcce23e42a8e654', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750849, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e16290ae4fc75fd764d2e0f3b64c9ca5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748089, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2195c1fa42db4aa632f26bee6d707d4c', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748179, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f2613225fce83a215ba2f356affdb143', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360750961, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('329a21ea130bb979edc0b57d6ffff16f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745089, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5c571d579b7bbe04f971d17c7f5a583e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745179, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('35a23636ce38629e870676424cf753c1', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360745261, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('70fbd55e7de7539be70134124dba34e6', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360745311, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('417c0638fb0bdc09d02f85af3ee65c81', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745389, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3e0f984c83056e5979b6d5c714596088', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745479, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7f3ca0991413832f5bbeefc5305623ba', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360748261, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('9ac1488c65d1d24ba73a4bacf5923323', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360748312, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('73aa67ab23efc7a5d4645cefcc36a149', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748389, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0522a4832887b7d15b57eef056c7ebad', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748479, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2dcc3530cbcb64319d719658e7df1b0c', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750999, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d45669cce4601fcf2249784822ed57df', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360748561, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('887a32230f51b77eca1f33c2fb7351ea', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360748612, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('6836b816067d40d483b4eb224f714b89', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748689, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('db6cfd714fa7c8bef183728f422f2efb', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748779, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0307355d8c2a48df36efdf8c45ac762d', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360748862, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('9ceb68eff5ef30e5382ad06382b268a1', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360748911, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b972e1de52e9425c00ad5d8a0e5626d5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748989, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('88003e4946e223104c8f846670757b18', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749079, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('8f6eabdb44cf000825b23ee19f396b7b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747969, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0b4b9f7f7626c1cb551b81ae100e3857', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750819, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('62cd00b082a2f85789922503f723d317', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748029, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2d510ebfd4a6d0d26e3215b69fefbc67', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748119, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('69d31c00c0243366be1cc7dcd8cec2c9', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748209, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('25ac3c0a2aef2db6c43fbba29bb2e42a', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748269, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('4179f31fe6e6519a434ad27f7a4b80ed', '94.254.4.85', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/536.26.14 (KHTML, like Gecko)', 1360750851, 'a:3:{s:9:"user_data";s:0:"";s:9:"auth_user";s:1:"1";s:13:"auth_loggedin";b:1;}');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('28e11067ca55055df1347a642a0fc858', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745030, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f71bfa506bf484ea6f9096332c97ea6b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745119, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c9783fd88ca44f6244c09210c17334ed', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745209, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('42f2e54f56dc3786b4a74030c7fd24ab', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745269, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0ca82ebf357c15f9c9ca21085f1d215e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745329, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e7c013465c9d7b08798f82fa33bc0372', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745419, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('45a0ba1bd8f68d6d115d8619249787af', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745509, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('cf7b8d37304d1d1af5332a12a5d2e6ad', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748329, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('71e224c0373fdd111dc7645d0e6ed7dc', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748419, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('50a67135cb25f24cf161462573616533', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748509, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('4f0872978f0206e9b2015ffad3e37b80', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750879, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c79c1bfa2dc3e0d92fec49d0ae533147', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750910, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e6eca720d12655af4a9b60bf2916061c', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750969, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('9e541152eaa23406366066abb77d1be9', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748569, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d606a29af1a7b17bdd803b6f27a6f75b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748629, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('8b960c608c796e5a99624391c81b7046', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748719, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('280023e90aeafd12d4c2e5dac166b7fc', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748809, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('48dedca9afc1c57c269d05076f0d7578', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748870, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('99d35545c3a4a1c0927c0266e1f5e410', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748929, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('4f686020cc85be0cd00893677fb81447', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749019, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d6afbe2e2a4939cbced045fe86af497d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749109, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5d73e46b1d3eb68703ff4b77e9db83a6', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747999, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('83af02f617aa8b7c784dc1a80c248485', '94.254.4.85', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/536.26.17 (KHTML, like Gecko) Version/6.0.2 Safari/536.26.17', 1360750883, 'a:3:{s:9:"user_data";s:0:"";s:9:"auth_user";s:1:"1";s:13:"auth_loggedin";b:1;}');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('bf4d39f02bd77229e89e4659eb8f600e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750939, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0badd30a18f6703651f95a4c3ffb088f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748059, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2c974b95135f8788dc2c296e81f1b1a2', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748149, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('88f55dd0b1e83f6336c7c932ac938fe6', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748239, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('a9c4ac3af38cf459ab373bf9cae7a5bf', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748299, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('de5c78421b51dc243a5cc4ecb6201192', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748359, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7a08253ee21adcd3b865b4f2ff67dd98', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748449, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0dc17a121d105355d962fcd379590fd5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745060, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d1a89b1da135d27a226248760ae3994a', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745149, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('50aa08df2a9158ee812eda8d72f1c069', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745239, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('1eabcd595b59c26c8104c3d8aa9bc146', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745299, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ef31fd83cda429803ed51bc9ecc1cd2b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745359, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c6d6ac4bc00dde8faabf9ddcc6e30679', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745449, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('45b37d22991dac028f7b410e4b205dbe', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748539, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('134ad6bc08d47b73a59dcb7522789001', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751269, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e95ef45bfe5327a938faf37447f210c6', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360751321, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d064bd122f49fa5287dd45c64a8cd01e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751390, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c08f0b74bc61a60e181867f1f45ebf78', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751482, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c5ea88d37990b20d6817d8521fb4b5c3', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751569, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('02593543bb2bd5934e93a9103cb7f375', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745539, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e4b02fbe3e24f5cd28ee9ac24c072ece', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748599, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ee48b7b17d80ad2b53dd33be5c2bb92a', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748659, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('abf68a920c4bdd9f2f765c42e46ce945', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748749, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('a71d8468fa05774b3f94753f6bd8c28b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748839, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b4f5b3c5157fa75c2d7d1f70451d8fc4', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748899, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b82d566b2c618e92b3eb1c69f77576e5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360748959, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('8869e37bfce142a0b86e39fd4f18944a', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749049, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('cfe4222f7d829f87760d6abfef7ceffd', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360751621, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('a17d5bc8b369a65019dd0d0e004e3384', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751689, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e536c76a367256fe4598b26112d3fa95', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749139, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('a2b14044d3440bd0a8c4e1e68ff04a4f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751779, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('459079cc81de000c6a94d947f51b4f2d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751869, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5bed754a45b5e4e5d0ede7343365e8b9', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360751921, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b63f7a2a54a67634f8c5bd9e31ecf491', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751989, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f6d583e85ee5c5af4ec023fcb6ebf6ad', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752079, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f9319a486d87a94e2eeee6a1b315389f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752169, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('1b823ab87226c411df273871e2eabf79', '192.168.1.131', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/536.26.17 (KHTML, like Gecko) Version/6.0.2 Safari/536.26.17', 1360750831, 'a:3:{s:9:"user_data";s:0:"";s:9:"auth_user";s:1:"1";s:13:"auth_loggedin";b:1;}');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('42ea2d06d787648e9ba5f072b8a45810', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360751012, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('23d23b6fed12c8e337ce50352f29b069', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751089, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2882d945817bf47325ba0598ccb41c31', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751179, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2073e526ffe0e18434243cae355e883c', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751299, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b6775270c6efd6669d7bdec4a73b994b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751329, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f3fe9965744c8b7a39955d3d4685216d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751420, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('aaedc02df2d6d9be0ecb6316b0d4909a', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751509, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('40b126efe794732117b94b5f189a8a61', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751600, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('996443777d01d3d2667b45aebad1aee8', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360745562, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c5f0ee6c41047a0cd502adb206479e33', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360745612, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('573dfb762eb5f30ca4ee6a76e0026009', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360749161, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2ea11dd2c91571bd9f5dff1317f86fa2', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360749212, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c5b8fc28ab48ee835aeb4f76968625af', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749289, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f0d332e307608f8b43af9433d9852f90', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751630, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('4de8093bcf353be6d14949bc229bef93', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751719, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('07f995543115d8b5c023837e471d3d1f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745689, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('22c418eda7e68bc56fab2eacbae87235', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745779, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('a6a21e75a182c03729d6490686f7b4a2', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745869, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b2e1592548e32786a442608057c1259b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745929, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('203abda41d3c8b33d46949d637edfa42', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746019, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('272f0f0125801ff20dc939443fa6bba4', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746109, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('37cf00846a016da99fb5585d21be25d1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746169, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('cde6740a5c32745ebfb47ea8ddb1d34a', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749379, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('6a3aed9dea7888f7c1a039ce102357f5', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360749462, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('15da9e2e090d53369eaad891c8359af7', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360749512, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('add06e4a7cf3e99c84a978f12a0cf574', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749590, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7152e4e44396dffef011123b36140255', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749679, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b3137c1cba2c7f1982676a988103894f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751809, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('41c9d4b790fdd14fb346051ab1d58ec8', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751899, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ae1b2ce7e8da795ae3cfe8a75b38e4dd', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751929, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7fa50304a1b6496e6e9cdb86f02fe1f2', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752019, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f9d0f97bf0de6269e9128688b895837e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752109, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('09bbdada2244ba123e9d5b2f28129ced', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746229, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('035d9f76fe1ff52fd1da31a19a5d394b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746319, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f3cbc0e87e7df218cf790eb30608e266', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746409, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('6e17dc844ea2a3efd9d8628848f45ecc', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746469, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e6b8096c8f43ddb263413241566a0a47', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746529, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('4477dc8cb787680e16e71f7b2260705e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746619, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('a44bb7769f067f8661546e88d5ac7d3f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746709, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('cc925c1777c5189ddeb0500e41372d6a', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746769, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0d5c511eaba972a4eb588087aee39238', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360749762, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ec1dcf77488ca7cb1f8bfa421466ad69', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360749812, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('a4ca02b27b73a745e93ee94699d00502', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749889, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('48f37333fcb1c19a0c27c25224ba3ea1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749979, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2e9043c9b0d6f2bc7af5125ba42a52fe', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746829, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('77c261da4a76f7161848d60dc85a05b1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746919, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7d5cd0bdcb8741f90a61bfdab0ff26de', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751029, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d2900c1ce5d2c93c5c98878a5e0016cb', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751119, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ca51df42af44f9f8e33c77b64824efea', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360751312, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7c5ae23ba33147c61bc7550ccb02c8a7', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751359, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e2d80abc82309164fa94ea29ef8e77b2', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749169, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d7a1f44c6c143956f6d0fc2251b3d365', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751449, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('17425618f4b2574a13f08726bd47dd86', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749229, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('4efa7ccfd83759d0e7ffcd58ffc53e94', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749319, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('12ddaccf60322fa71e24399b1b4543cf', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749409, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('809af985f82974e1245d6277c8785663', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751539, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b7ded759c8a55f60d0c3fc9a57bfaf28', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749470, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3c18dc097fa3b17360182a638b4bf188', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360751612, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('feb4f4005ccea362f028c482551a7713', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745569, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('8b63f8a911c16a5270a1242cd90c4acf', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745629, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('92830e0ace82e3bdec1947fe51a82486', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745719, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('1de52432e32443d98baf1ec3fbdf93ed', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745809, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('35468979e108b331b18730f0088083ce', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745839, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2959f0e7d98ece8e4677a9768f72a382', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745899, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('27a3f14d887aaa3d427eb659a781caee', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745959, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('52eb04c950e2bec9441e6028cc112c2d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746049, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d38fe6628f5b6d164fe83e2466dd889d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746139, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('dd73bca5780e0c99a1876317e3c549f4', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746199, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7bfd7a8591d7e56288508723452a0041', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746259, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('98b5b1083ab32db3cc3b5b0771f7b659', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746349, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d04cfb66039aa22e000565574fa72320', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749529, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('bbb03aeb11cbee775857863b64d07ce2', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749619, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b320e25147cde7372c8cb76a0973a224', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749709, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e317b06d672ee32a732b0529e0416ee5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749770, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2fad5a4589a62815e97f524911e420f1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751659, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d559cb18e4534803130b50dfa18d0742', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751749, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b0c3bfe4c2c705d75fd1d596057fffac', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751840, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b60d0e4c4c1b275ee43e879af45b89db', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360751912, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('558bd38537dbb22f44e8ee4177f43837', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751959, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7884b24928a5f5adfd67028330d8825c', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752049, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('86baaeb6ea6a5823cd2477fb383c66e3', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746439, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('efb5de018e66b080a80e109f337f770e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746499, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('becbdeeed45824fbb3ad9d7ccb89cfe2', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746559, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('09bf7415c4cf7d840ffab170489b4a50', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746649, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('198964f2a7c11e50e7787845127ab0cd', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746739, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('70456940b92ab2677c36e9a7a53fea46', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746799, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('1b83fe1f661bd6eee42ceb2a52220847', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746859, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('961f9f73b3fcc3d342a6afbe698e7ee8', '46.194.178.55', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/534.57.7 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.7', 1360747728, 'a:4:{s:9:"user_data";s:0:"";s:8:"messages";a:1:{s:5:"error";a:1:{i:0;s:14:"Wrong password";}}s:9:"auth_user";s:1:"2";s:13:"auth_loggedin";b:1;}');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5d98eae35768d9f6abe9c3afd76e30b0', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749829, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e548a925c0536b166cd81473ae12fc4e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749919, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0f0e07a7b6038b33931e7d9573c5d1d5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750009, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('622b284821f36bd4c6a659925c74c273', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752139, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d5c1fbfac059a9cce7388deaa2395dc2', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751059, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('46e352ccae4040ba9d211373a7ef202f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360751149, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('22492673effca79f4701383b62a66e46', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752200, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('9d0fc7ee692812e9d384e04dcdc075aa', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752229, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('517da3be45e0a5ef82c7c4164aa7035d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749199, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('a58d78dec8bec0c0a9e195dd6d34c1d1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749259, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('6981070340c50948b2a77169d7b5f11f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749350, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('bb264d7a306f06d4ca47a33f767b65b6', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752319, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('9a24ce5f160ca5d8daa35dab51c5c7c9', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752409, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2b5f8819fbc281dfcc3b0da5db8c2298', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752499, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e8f41abf9c8c4ed6ba8b5cf596c2288b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752529, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('df6fd96eb3f7c3472fc14d702e9f56b1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745601, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2c0760f272472dafc223622a7ee66d36', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745659, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('8f9e7995af044a16e194ca4966045495', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745749, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('8a16f4b54eeb2f40f89c0ce9618d5c85', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360745861, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7bc3d3ba0c292f70e55ddf95b2d6e5e1', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360745912, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('6e8e9b6393676f8e1d208cd4a93b4c05', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360745990, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0e86039135658123ce95b254981f5ebe', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746079, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3b600520a409aee0562e0c1d6e1a199d', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360746161, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f786a2c5cde587ed569871ecce3b763a', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360746212, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ebf7c189208760a0a9a33339540edebb', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749439, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('02ec004bacf439f85c57b64a78e3d5a4', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749501, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('4cb8d19211376912d67359ef29c97db7', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749559, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e5fa888406711c8b93a6cec17811f2f8', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749657, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e952e1d9cf0e8f7f473e933fec5bdffb', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746289, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('471e07023eeaead32ec80761f760e627', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746379, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5a70eedb7cf7d79b7203d12f7e7e92f5', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360746461, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ac11c22dd2f1eb0e9e86937998ab6ee6', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360746512, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2810d22004a253eb984de0e98a783d9d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746589, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('851b87b3a3036b2908c675fde7fd0655', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746679, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('1d4aa0a556606b452ed391c2a14b87b3', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360746761, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e021ce67be1f15eec0ddb090b51c1ce4', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360746811, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('75fb8992cc75deafd283e619c9f469c4', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749739, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('454ba8d62541fd2b62531ce77bcbfbda', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749799, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('644a5b878311c3a0650a708712729f99', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749859, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3e95d4550d87a72c76f1d8f98b10e95e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360749949, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3737c656528e4222812f4e6fadc98f76', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750039, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c7a8eafa4154e8a01abf36eef8439d03', '94.254.4.85', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/536.26.17 (KHTML, like Gecko) Version/6.0.2 Safari/536.26.17', 1360750746, 'a:3:{s:9:"user_data";s:0:"";s:9:"auth_user";s:1:"1";s:13:"auth_loggedin";b:1;}');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('11dff52d4841933897ffabc1c53c6fcc', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746889, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('73b0d3760524982002d909b198b5e281', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360750062, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('cfc2b8ab4ec3538cac9d24730bfc51a6', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360750111, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('8657eced4fbf2c068922b9fa3cc843ed', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360752212, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b50d7309cfdbdeb367f7b2ed6d08efe3', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746949, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('998bfe1e1f3a9ba6c984da2e86486909', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750189, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('02ff50b86f528275fb708183b1ca804f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750279, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3597e8ae5d2de6a994bed44af391f0d5', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360750362, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('69bb8315fd0c7e1c7f1bf00281f6cdaf', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752259, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('fe18cf419654563f8ac30927e7e51e1f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747039, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('547f604443cecd53f6e51d9a63e49ff5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747099, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3131500cdb1ae5b6af6ae1f1fe23a95d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747159, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('146c55bd8c80a2b0d5408a313f36717c', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747250, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f48bd6f6e8b528e5810319099ba7e39b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747339, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3d3f80b6845849dd21116440ded482e3', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747399, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('b66c3bfca15325695d258103e5033ef6', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747459, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('51bc58adecac502be30b70ec96f85ac8', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747549, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('488d75363e80d893452bbccbb36dedbb', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747639, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5994d0915857144f09bbfee670507cff', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747699, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('26519e69c2117e97be8abebae436c698', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747729, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('47e99bd379be84f0060a72c809e985a3', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747819, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3881567711cd9b456b5474b4f7785c8b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747909, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('1ca8dc1b7a99efee39582e24efeda8eb', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360750412, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('bdbe95d1d0f9cf416434e79e40153651', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750489, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('287aa33e3e0e03ce8daa7d48a7c54d02', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750579, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ae27f3fc4da51bf0871eea504653d40e', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360750661, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('aca01cd4e4775236404281ffee0965d7', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360750712, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('32c8ed11827fb087e577421104fa495c', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750760, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ced6106278b7870479e20a576c951b6a', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752349, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('6cc9507ee184dfa2c859abcf9a946b70', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752439, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('28da8824cf7dbef15ccebc41c4137aab', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360752512, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5550b72a6d30d4c8c12d957a3911bcba', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752559, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c5b9aa13f4ce560b85221c3d925d5ff2', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360746979, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5049a2029bd42d4da3b7f80486a45593', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750069, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7aeed13d003599335bae143d5194beb1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750129, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d74a3ef392c3f2859ac36117f985cd3e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750219, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('552d508cedcbd9a30372cd2fafd272ba', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750309, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c66505fc67748da0cc1ec37ae8903da7', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750369, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('94d58fa9c9f1d1f0e42af071954251eb', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360752221, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('66a5b54f8b7949e9061a9bc893802279', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752289, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('d7d449562547a834ff9b61083e325556', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360747061, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e0c7b82a7fdfeb8eef3c021b5a8e377f', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360747112, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('45976bed8bc7b0112e98fd7f0d49f341', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747189, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('afd8072baed5360531e020a7dd4c585e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747279, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('089e2e03f7e367f8da656c3a99898e41', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360747361, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('3fb245cc767f02ccc8fe900c88ac8be6', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360747412, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('0b02f1096ee5595a6c126e84c305a000', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747489, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('545ae9cbce71332a509f8f8908983f9d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747580, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('49346820ba1750a4a713bec5c30c6a41', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360747661, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('7338c7fed812330116f64be80f924768', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360747712, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('9c47b3d2e48986d14a2c0aabc1da2de4', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747760, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('46a600bdf5bb404aea25100af401a5d1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747849, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('aa1279ed804edf5290965c5c8b7a22d0', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747939, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('eb9004268ad89f8014dd19073e985ba2', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750429, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ef3f3a00e2ffa7400e1a6887ac7cef8c', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750519, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5d9e98ec7bb7abdec5c856dcf881b93d', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750609, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('26b3ff59221ab5c750f1b6658b8602be', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750669, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('67ceb0ac1e3da36761983fb577c6731c', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750729, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('19410594ef3884368b281d21136384e7', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752379, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('e7df53b4c36b78a25dc9694318af82bd', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360752469, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('99c40b8e81327a5c5b2e46e973d9eac9', '192.168.160.1', 'check_http/v1.4.15 (nagios-plugins 1.4.15)', 1360752522, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('602820bf6eb708f356e3b01db24f2255', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750099, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('4f4351d6e4487c2cc592fef79b736ca8', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750159, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('58550a2c65d8d9464fcbc79e8015b972', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750249, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('45c4df9f624073d5de167221e9a930c5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750340, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('236286b871a9180b7a61d7b9496b21a1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750399, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('50de758142ead3acdde58ad6ad5c488b', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750459, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('2099e3b01a20def3ef1f0951324e55c8', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747009, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('bb688acd17127d5d1607eaae09644ed1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747070, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('17b4b7ca50f509e62218b5d135f51a7f', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747129, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('77e6e91e6927b8d4ab39876946f39f07', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747219, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('5f94f368478c1b33bf6e4cff7853e019', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747310, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('ac7b5f4e77009b0ecb5288d0a55b2959', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747369, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('998e997b6017ccc2f4b1a19d65692ba5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747429, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('094dba22c8e70392dbba6fd6ad42d9ba', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747519, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('64221371bdbc470bd654af6c46545165', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747609, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('cd28f888ddb31654c7d87c6f0708745e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747669, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('8bfcc010d4e1f3a2e09da1e84afd2540', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747789, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('f5ce1345bb815fe5c1326c55f9706e1a', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360747879, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('c2c6e0f5681a8e258f55e11a4ac586e5', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750549, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('9fc0295fb5f0d3bd6b9e354c90d4988e', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750640, '');
INSERT INTO ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) VALUES ('177c630f9499071227527220496456b1', '10.200.57.129', 'ELB-HealthChecker/1.0', 1360750699, '');


--
-- TOC entry 2049 (class 0 OID 16774)
-- Dependencies: 182
-- Data for Name: keys; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO keys (id, key, level, ignore_limits, is_private_key, ip_addresses, date_created) VALUES (1, 'b84b9eb779c6706ce75584c29b8005b1', 2, false, false, NULL, 0);


--
-- TOC entry 2077 (class 0 OID 0)
-- Dependencies: 181
-- Name: keys_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('keys_id_seq', 1, true);


--
-- TOC entry 2053 (class 0 OID 16798)
-- Dependencies: 186
-- Data for Name: limits; Type: TABLE DATA; Schema: klubb; Owner: klubb
--



--
-- TOC entry 2078 (class 0 OID 0)
-- Dependencies: 185
-- Name: limits_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('limits_id_seq', 1, false);


--
-- TOC entry 2034 (class 0 OID 16630)
-- Dependencies: 166
-- Data for Name: log; Type: TABLE DATA; Schema: klubb; Owner: klubb
--



--
-- TOC entry 2079 (class 0 OID 0)
-- Dependencies: 165
-- Name: log_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('log_id_seq', 1, true);


--
-- TOC entry 2051 (class 0 OID 16787)
-- Dependencies: 184
-- Data for Name: logs; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (1, 'role/rights/role/2/X-API-KEY/b84b9eb779c6706ce75584c29b8005b1', 'get', 'a:2:{s:4:"role";s:1:"2";s:9:"X-API-KEY";s:32:"b84b9eb779c6706ce75584c29b8005b1";}', 'b84b9eb779c6706ce75584c29b8005b1', '10.0.1.200', 1357947309, false);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (2, 'role/rights/role/2/X-API-KEY/b84b9eb779c6706ce75584c29b8005b1', 'get', 'a:2:{s:4:"role";s:1:"2";s:9:"X-API-KEY";s:32:"b84b9eb779c6706ce75584c29b8005b1";}', 'b84b9eb779c6706ce75584c29b8005b1', '10.0.1.200', 1357947348, false);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (3, 'role/rights/role/2/X-API-KEY/b84b9eb779c6706ce75584c29b8005b1', 'get', 'a:2:{s:4:"role";s:1:"2";s:9:"X-API-KEY";s:32:"b84b9eb779c6706ce75584c29b8005b1";}', 'b84b9eb779c6706ce75584c29b8005b1', '10.0.1.200', 1357947449, false);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (4, 'role/rights/role/2/X-API-KEY/b84b9eb779c6706ce75584c29b8005b1', 'get', 'a:2:{s:4:"role";s:1:"2";s:9:"X-API-KEY";s:32:"b84b9eb779c6706ce75584c29b8005b1";}', 'b84b9eb779c6706ce75584c29b8005b1', '10.0.1.200', 1357947567, false);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (5, 'role/rights/role/2/X-API-KEY/b84b9eb779c6706ce75584c29b8005b1', 'get', 'a:2:{s:4:"role";s:1:"2";s:9:"X-API-KEY";s:32:"b84b9eb779c6706ce75584c29b8005b1";}', 'b84b9eb779c6706ce75584c29b8005b1', '10.0.1.200', 1357985995, false);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (6, 'role/rights/role/2/X-API-KEY/b84b9eb779c6706ce75584c29b8005b1', 'get', 'a:2:{s:4:"role";s:1:"2";s:9:"X-API-KEY";s:32:"b84b9eb779c6706ce75584c29b8005b1";}', 'b84b9eb779c6706ce75584c29b8005b1', '10.0.1.200', 1358034683, false);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (7, 'role/rights/role/2/X-API-KEY/b84b9eb779c6706ce75584c29b8005b1', 'get', 'a:2:{s:4:"role";s:1:"2";s:9:"X-API-KEY";s:32:"b84b9eb779c6706ce75584c29b8005b1";}', 'b84b9eb779c6706ce75584c29b8005b1', '10.0.1.200', 1358114101, false);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (8, 'role/rights/role/2/X-API-KEY/b84b9eb779c6706ce75584c29b8005b1', 'get', 'a:2:{s:4:"role";s:1:"2";s:9:"X-API-KEY";s:32:"b84b9eb779c6706ce75584c29b8005b1";}', 'b84b9eb779c6706ce75584c29b8005b1', '10.0.1.200', 1358114242, false);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (9, 'role/rights/role/2/X-API-KEY/b84b9eb779c6706ce75584c29b8005b1', 'get', 'a:2:{s:4:"role";s:1:"2";s:9:"X-API-KEY";s:32:"b84b9eb779c6706ce75584c29b8005b1";}', 'b84b9eb779c6706ce75584c29b8005b1', '10.0.1.200', 1358114258, false);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (10, 'role/rights/role/2', 'get', 'a:1:{s:4:"role";s:1:"2";}', '', '10.0.1.200', 1358114423, true);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (11, 'role/rights/role/2', 'get', 'a:1:{s:4:"role";s:1:"2";}', '', '10.0.1.200', 1358116197, true);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (12, 'role/rights/role/2', 'get', 'a:1:{s:4:"role";s:1:"2";}', '', '10.0.1.200', 1358118631, true);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (13, 'role/rights/role/2', 'get', 'a:1:{s:4:"role";s:1:"2";}', '', '10.0.1.200', 1358118734, true);
INSERT INTO logs (id, uri, method, params, api_key, ip_address, "time", authorized) VALUES (14, 'role/rights/role/2', 'get', 'a:1:{s:4:"role";s:1:"2";}', '', '94.254.4.85', 1360153339, true);


--
-- TOC entry 2080 (class 0 OID 0)
-- Dependencies: 183
-- Name: logs_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('logs_id_seq', 14, true);


--
-- TOC entry 2036 (class 0 OID 16653)
-- Dependencies: 168
-- Data for Name: member_data; Type: TABLE DATA; Schema: klubb; Owner: klubb
--



--
-- TOC entry 2081 (class 0 OID 0)
-- Dependencies: 167
-- Name: member_data_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('member_data_id_seq', 1, false);


--
-- TOC entry 2055 (class 0 OID 25557)
-- Dependencies: 188
-- Data for Name: member_flags; Type: TABLE DATA; Schema: klubb; Owner: klubb
--



--
-- TOC entry 2082 (class 0 OID 0)
-- Dependencies: 187
-- Name: member_flags_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('member_flags_id_seq', 1, false);


--
-- TOC entry 2038 (class 0 OID 16665)
-- Dependencies: 170
-- Data for Name: members; Type: TABLE DATA; Schema: klubb; Owner: klubb
--



--
-- TOC entry 2083 (class 0 OID 0)
-- Dependencies: 169
-- Name: members_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('members_id_seq', 33, true);


--
-- TOC entry 2047 (class 0 OID 16763)
-- Dependencies: 180
-- Data for Name: migrations; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO migrations (version) VALUES (0);


--
-- TOC entry 2040 (class 0 OID 16678)
-- Dependencies: 172
-- Data for Name: rights; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO rights (id, role, add_members, add_users, use_system) VALUES (1, 1, true, false, true);
INSERT INTO rights (id, role, add_members, add_users, use_system) VALUES (2, 2, false, false, true);
INSERT INTO rights (id, role, add_members, add_users, use_system) VALUES (3, 3, true, true, true);


--
-- TOC entry 2084 (class 0 OID 0)
-- Dependencies: 171
-- Name: rights_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('rights_id_seq', 3, true);


--
-- TOC entry 2042 (class 0 OID 16695)
-- Dependencies: 174
-- Data for Name: roles; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO roles (id, name, system) VALUES (1, 'Administratör', true);
INSERT INTO roles (id, name, system) VALUES (2, 'Användare', true);
INSERT INTO roles (id, name, system) VALUES (3, 'Superadministratör', true);


--
-- TOC entry 2085 (class 0 OID 0)
-- Dependencies: 173
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('roles_id_seq', 3, true);


--
-- TOC entry 2043 (class 0 OID 16704)
-- Dependencies: 175
-- Data for Name: system; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO system (key, value) VALUES ('org_name', 'Ung Cancer');
INSERT INTO system (key, value) VALUES ('app_name', 'Medlemsregistret');
INSERT INTO system (key, value) VALUES ('org_type', 'förening');
INSERT INTO system (key, value) VALUES ('inactive_title', 'Avliden');
INSERT INTO system (key, value) VALUES ('inactive_date_title', 'Datum');


--
-- TOC entry 2045 (class 0 OID 16711)
-- Dependencies: 177
-- Data for Name: types; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO types (id, name, plural, "desc") VALUES (1, 'Medlem', 'Medlemmar', NULL);
INSERT INTO types (id, name, plural, "desc") VALUES (2, 'Anhörigmedlem', 'Anhörigmedlemmar', NULL);


--
-- TOC entry 2086 (class 0 OID 0)
-- Dependencies: 176
-- Name: types_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('types_id_seq', 2, true);


--
-- TOC entry 2056 (class 0 OID 25565)
-- Dependencies: 189
-- Data for Name: types_requirements; Type: TABLE DATA; Schema: klubb; Owner: klubb
--



--
-- TOC entry 2046 (class 0 OID 16739)
-- Dependencies: 178
-- Data for Name: user_role; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO user_role ("user", role) VALUES (1, 3);
INSERT INTO user_role ("user", role) VALUES (2, 1);


--
-- TOC entry 2031 (class 0 OID 16594)
-- Dependencies: 163
-- Data for Name: users; Type: TABLE DATA; Schema: klubb; Owner: klubb
--

INSERT INTO users (id, username, firstname, lastname, email, phone, key, password, registered, first_login, loggedin) VALUES (1, 'jan', 'Jan', 'Lindblom', 'jan@nyfagel.se', '0731-509 338', 'w87p7zjWbikHvJ+yja0QqmCmWMb1GAjLNZjUYoMW/tiSKrK9iz+fpvwX4JFePKv3C1BTqE6U/2oR73RWAw7ljw==', '$2a$08$gNc6oAbrTTT3tVeHTnE9je2oSUPvv7bxnzoE3qG9mks8EZZtgEHYG', 1355861094, false, true);
INSERT INTO users (id, username, firstname, lastname, email, phone, key, password, registered, first_login, loggedin) VALUES (2, 'judith', 'Judith', 'Loménius', 'judith@ungcancer.se', NULL, 'gLr0CLylw4x6+5z/zUcmSA9eSJqfgdBAYGE2zWglXtRuuaWBjAy/lJHA+maTWpkq9rcGlGZhCxuxsLMOxmXq8A==', '$2a$08$yKhrHx8iSn6tpecXOdw1Zu/.rdOzgxJSkU3rHDGKGydtwma4BOW3y', 1357119301, false, true);
INSERT INTO users (id, username, firstname, lastname, email, phone, key, password, registered, first_login, loggedin) VALUES (16, 'test', NULL, NULL, 'test@nyfagel.se', NULL, 'nCVwRHzKCy8s+h1yBxRGxcTjdKmjAX/ZxIZFiJkHbIb1BkUrDz5MPUrwBbOTPulWvzT5Y4pMR9n07EFB0mQsCQ==', '$2a$08$bVi5iSty4oj/mdmMp.C2e.8i0.IvNuosGuYQU/mefFBLRZD4/jQZO', 1360750978, true, false);


--
-- TOC entry 2087 (class 0 OID 0)
-- Dependencies: 162
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: klubb; Owner: klubb
--

SELECT pg_catalog.setval('users_id_seq', 16, true);


--
-- TOC entry 1982 (class 2606 OID 16589)
-- Name: authentication_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY authentication
    ADD CONSTRAINT authentication_pkey PRIMARY KEY ("user", series);


--
-- TOC entry 1990 (class 2606 OID 16627)
-- Name: ci_sessions_pk; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY ci_sessions
    ADD CONSTRAINT ci_sessions_pk PRIMARY KEY (session_id);


--
-- TOC entry 2008 (class 2606 OID 16805)
-- Name: keys_key_key; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY keys
    ADD CONSTRAINT keys_key_key UNIQUE (key);


--
-- TOC entry 2010 (class 2606 OID 16784)
-- Name: keys_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY keys
    ADD CONSTRAINT keys_pkey PRIMARY KEY (id);


--
-- TOC entry 2016 (class 2606 OID 16803)
-- Name: limits_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY limits
    ADD CONSTRAINT limits_pkey PRIMARY KEY (id);


--
-- TOC entry 1992 (class 2606 OID 16635)
-- Name: log_pk; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY log
    ADD CONSTRAINT log_pk PRIMARY KEY (id);


--
-- TOC entry 2013 (class 2606 OID 16795)
-- Name: logs_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY logs
    ADD CONSTRAINT logs_pkey PRIMARY KEY (id);


--
-- TOC entry 1994 (class 2606 OID 16662)
-- Name: member_data_pk; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY member_data
    ADD CONSTRAINT member_data_pk PRIMARY KEY (id);


--
-- TOC entry 2018 (class 2606 OID 25564)
-- Name: member_flags_key_key; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY member_flags
    ADD CONSTRAINT member_flags_key_key UNIQUE (key);


--
-- TOC entry 2020 (class 2606 OID 25562)
-- Name: member_flags_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY member_flags
    ADD CONSTRAINT member_flags_pkey PRIMARY KEY (id);


--
-- TOC entry 1996 (class 2606 OID 16733)
-- Name: members_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY members
    ADD CONSTRAINT members_pkey PRIMARY KEY (id);


--
-- TOC entry 1984 (class 2606 OID 16604)
-- Name: pk_id; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT pk_id PRIMARY KEY (id);


--
-- TOC entry 1998 (class 2606 OID 16703)
-- Name: rights_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY rights
    ADD CONSTRAINT rights_pkey PRIMARY KEY (id);


--
-- TOC entry 2000 (class 2606 OID 16700)
-- Name: roles_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- TOC entry 2002 (class 2606 OID 16708)
-- Name: system_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY system
    ADD CONSTRAINT system_pkey PRIMARY KEY (key);


--
-- TOC entry 2004 (class 2606 OID 16716)
-- Name: types_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY types
    ADD CONSTRAINT types_pkey PRIMARY KEY (id);


--
-- TOC entry 2022 (class 2606 OID 25569)
-- Name: types_requirements_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY types_requirements
    ADD CONSTRAINT types_requirements_pkey PRIMARY KEY (fieldname, type, rule);


--
-- TOC entry 1986 (class 2606 OID 16608)
-- Name: u_email; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT u_email UNIQUE (email);


--
-- TOC entry 1988 (class 2606 OID 16606)
-- Name: u_username; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT u_username UNIQUE (username);


--
-- TOC entry 2006 (class 2606 OID 16743)
-- Name: user_role_pkey; Type: CONSTRAINT; Schema: klubb; Owner: klubb; Tablespace: 
--

ALTER TABLE ONLY user_role
    ADD CONSTRAINT user_role_pkey PRIMARY KEY ("user", role);


--
-- TOC entry 2011 (class 1259 OID 16811)
-- Name: fki_api_key_fk; Type: INDEX; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE INDEX fki_api_key_fk ON logs USING btree (api_key);


--
-- TOC entry 2014 (class 1259 OID 16822)
-- Name: fki_limits_api_key_fk; Type: INDEX; Schema: klubb; Owner: klubb; Tablespace: 
--

CREATE INDEX fki_limits_api_key_fk ON limits USING btree (api_key);


--
-- TOC entry 2025 (class 2606 OID 25544)
-- Name: members_data_fkey; Type: FK CONSTRAINT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY members
    ADD CONSTRAINT members_data_fkey FOREIGN KEY (data) REFERENCES member_data(id) ON DELETE SET NULL;


--
-- TOC entry 2026 (class 2606 OID 25549)
-- Name: members_type_fkey; Type: FK CONSTRAINT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY members
    ADD CONSTRAINT members_type_fkey FOREIGN KEY (type) REFERENCES types(id) ON DELETE SET NULL;


--
-- TOC entry 2023 (class 2606 OID 16609)
-- Name: user_fk; Type: FK CONSTRAINT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY authentication
    ADD CONSTRAINT user_fk FOREIGN KEY ("user") REFERENCES users(id) ON DELETE CASCADE;


--
-- TOC entry 2024 (class 2606 OID 16636)
-- Name: user_fk; Type: FK CONSTRAINT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY log
    ADD CONSTRAINT user_fk FOREIGN KEY ("user") REFERENCES users(id) ON DELETE SET NULL;


--
-- TOC entry 2028 (class 2606 OID 16749)
-- Name: user_role_role_fkey; Type: FK CONSTRAINT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY user_role
    ADD CONSTRAINT user_role_role_fkey FOREIGN KEY (role) REFERENCES roles(id) ON DELETE CASCADE;


--
-- TOC entry 2027 (class 2606 OID 16744)
-- Name: user_role_user_fkey; Type: FK CONSTRAINT; Schema: klubb; Owner: klubb
--

ALTER TABLE ONLY user_role
    ADD CONSTRAINT user_role_user_fkey FOREIGN KEY ("user") REFERENCES users(id) ON DELETE CASCADE;


--
-- TOC entry 2064 (class 0 OID 0)
-- Dependencies: 6
-- Name: klubb; Type: ACL; Schema: -; Owner: klubb
--

REVOKE ALL ON SCHEMA klubb FROM PUBLIC;
REVOKE ALL ON SCHEMA klubb FROM klubb;
GRANT ALL ON SCHEMA klubb TO klubb;
GRANT ALL ON SCHEMA klubb TO PUBLIC;


-- Completed on 2013-02-13 11:49:32 CET

--
-- PostgreSQL database dump complete
--

