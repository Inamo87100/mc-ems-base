# 🎓 MC-EMS – Exam Management System
## *Il tuo partner per esami professionali, veloci e senza stress*

> **Versione Base**: 2.4.2-base &nbsp;|&nbsp; **Versione Premium**: 2.2.6.4-premium &nbsp;|&nbsp; WordPress 6.0+ &nbsp;|&nbsp; PHP 7.0+

---

## 📣 Introduzione commerciale

Stanco di gestire esami via email, fogli di calcolo e promemoria manuali?

**MC-EMS è la soluzione definitiva** per scuole, università e centri di formazione che vogliono:

- 🎯 **Esami organizzati** – Calendari chiari, prenotazioni self-service, zero confusione
- ⚡ **Tempo risparmiato** – Automazione completa di prenotazioni, notifiche email e controllo accesso ai corsi
- 👥 **Candidati felici** – Interfaccia intuitiva, trasparenza totale, nessuna frustrazione
- 📊 **Controllo totale** – Gestione sessioni, assegnazione supervisori, esportazione dati e report
- 🔒 **Professionalità garantita** – Validazioni intelligenti, audit trail e conformità built-in

**MC-EMS si integra nativamente con Tutor LMS** e trasforma la tua piattaforma da semplice e-learning a **centro esami completamente automatizzato**.

Da piattaforma e-learning generica a centro esami professionale. In pochi minuti.

---

## 🎯 Cosa fa il plugin

MC-EMS è un **sistema completo di gestione esami** per WordPress costruito intorno a Tutor LMS. Consente a scuole, università e centri di formazione di:

- **Gestire sessioni d'esame** tramite un Custom Post Type dedicato, con date, orari, capienza e supervisori
- **Permettere ai candidati di prenotarsi** agli esami direttamente dal frontend con un calendario interattivo
- **Supportare più corsi per candidato** – ogni utente può avere prenotazioni attive per corsi diversi contemporaneamente
- **Controllare l'accesso ai corsi** in base alle prenotazioni: senza prenotazione valida, il corso è bloccato
- **Assegnare supervisori (proctors)** alle sessioni e gestire la loro agenda con un calendario dedicato
- **Automatizzare tutte le comunicazioni email** (conferme, cancellazioni, notifiche admin, avvisi supervisore)
- **Gestire sessioni speciali** per candidati con esigenze di accessibilità (capienza fissa = 1)
- **Esportare i dati** delle prenotazioni in CSV con un click

---

## 🚀 Funzionalità Base – Versione gratuita

### 1️⃣ Gestione sessioni d'esame

**Custom Post Type** (`mcems_exam_session`) con colonne personalizzate nel backend: corso, data, ora, posti totali, posti prenotati.

✅ **Generazione batch di sessioni**
- Seleziona corso, intervallo di date, giorni della settimana e orario
- Il sistema crea automaticamente tutte le sessioni richieste

✅ **Validazione intelligente**
- Impossibile creare sessioni nel passato
- Le sessioni già passate diventano automaticamente **read-only** nel backend: nessun rischio di modificare dati storici
- Restrizioni UI rigide per date/orari passati

✅ **Sessioni speciali (accessibilità)**
- Creazione di sessioni con capienza fissa = 1 per candidati con esigenze speciali
- Ricerca candidato per email (AJAX) e assegnazione diretta alla sessione
- Badge visivo ♿ nella lista sessioni

✅ **Aggiornamento capienza bulk**
- Aggiorna la capienza di più sessioni contemporaneamente tramite un range di date

✅ **Limiti Base** (protezione qualità):
- **Massimo 5 sessioni future attive** contemporaneamente
- **Massimo 5 posti per sessione**
- **1 orario per giorno** per sessione standard

---

### 2️⃣ Prenotazioni candidati – Il cuore del sistema

**Shortcode**: `[mcems_book_exam]`

✅ **Calendario interattivo frontend**
- Menu a tendina per selezionare il corso (obbligatorio)
- Navigazione mese/anno con indicatori visivi delle date disponibili
- Click su una data → visualizzazione di tutti gli slot disponibili per quell'ora

✅ **Codice colore visuale in tempo reale**

| Colore | Significato |
|--------|-------------|
| 🟢 Verde | Posti abbondanti (≥ 50% disponibilità) |
| 🟡 Giallo | Posti in esaurimento (25–50% disponibilità) |
| 🟠 Arancione | Ultimo posto disponibile (1 slot libero) |
| 🔴 Rosso | Completo (0 posti) |

✅ **Informazioni slot visibili**
- Orario, corso, posti disponibili, nome del supervisore assegnato
- Badge ♿ per sessioni speciali

✅ **Logica di prenotazione avanzata**
- Obbligo anticipo prenotazione configurabile (default: 48 ore prima della sessione)
- Prevenzione doppia prenotazione per lo stesso corso
- Supporto multi-corso: prenotazioni attive per corsi diversi contemporaneamente
- Caricamento AJAX — zero refresh della pagina

✅ **Integrazione Google Calendar**
- Bottone "Aggiungi a Google Calendar" per ogni prenotazione confermata
- Pre-compilazione automatica dell'evento con dettagli sessione (durata: 1 ora)

---

### 3️⃣ Gestione prenotazioni personali

**Shortcode**: `[mcems_manage_booking]`

✅ **Dashboard candidato**
- Elenco prenotazioni attive per ciascun corso (supporto multi-corso)
- Dettagli visibili: corso, data, ora, ID sessione, nome supervisore
- Storico prenotazioni passate (vista non modificabile)

✅ **Cancellazione prenotazione**
- Bottone di cancellazione se consentito dalle impostazioni
- Validazione scadenza cancellazione configurabile (default: 48 ore prima della sessione)
- Se troppo tardi, mostra un messaggio esplicativo invece del bottone
- Email di cancellazione inviata automaticamente al candidato e all'admin (se configurato)

---

### 4️⃣ Controllo accesso corsi – Il "cancelletto" intelligente

✅ **Come funziona**

Il gate si attiva a livello di `template_redirect` (priorità 0 — il più rapido possibile) e segue questa logica:

```
1. Gate abilitato?             NO  → Accesso consentito
2. Pagina di un corso?         NO  → Accesso consentito
3. Corso in lista gated?       NO  → Accesso consentito
4. Utente loggato?             NO  → BLOCCO "Devi effettuare il login"
5. Utente è admin/istruttore?  SÌ  → Accesso consentito (bypass)
6. Ha prenotazione valida?     NO  → BLOCCO "Nessuna prenotazione"
7. Prenotazione nel range?     NO  → BLOCCO "Prenotazione fuori finestra"
8. Tutti i controlli superati? SÌ  → Accesso consentito ✅
```

✅ **Impostazioni avanzate del gate**
- Abilita/disabilita il gate globalmente
- **Lead time** (`tutor_gate_unlock_lead_minutes`): minuti prima della sessione in cui il corso si sblocca (es: 30 minuti prima dell'esame)
- **Scadenza prenotazione** (`tutor_gate_booking_expiry_value` + unità ore/minuti): quanto tempo dopo la sessione il corso rimane accessibile (0 = mai scade)
- Selezione corsi da sottoporre al gate (vuoto = tutti i corsi)
- Selezione corsi visibili nel calendario di prenotazione

✅ **Pagina bloccata**
- Messaggio personalizzato in un box rosso
- Link diretto alla pagina di gestione prenotazione
- Header/footer del tema mantenuti

---

### 5️⃣ Calendario supervisori

**Shortcodes**: `[mcems_sessions_calendar]` · `[calendario_slot_esame]` (alias legacy)

✅ **Vista admin**
- Calendario mensile con navigazione mese/anno
- "Visualizza le tue sessioni assegnate" (per il supervisore loggato)
- "Visualizza tutte le sessioni" (per admin)
- Click su una data → dettaglio sessioni con numero prenotazioni

✅ **Azioni disponibili** (configurabili)
- Assegna supervisore a una sessione
- Riassegna supervisore (se `cal_allow_reassign = ON`)
- Rimuovi supervisore (se `cal_allow_unassign = ON`)

✅ **Email automatiche calendario**
- Notifica al supervisore all'assegnazione (configurabile)
- Notifica al supervisore alla rimozione (configurabile)
- **Avviso 24h** all'admin per sessioni del giorno dopo senza supervisore (cron automatico, ON di default)

---

### 6️⃣ Notifiche email – 7 tipi completamente personalizzabili

Ogni tipo di email ha soggetto e corpo **100% modificabili** con placeholder dinamici.

| # | Evento | Destinatario | Default |
|---|--------|-------------|---------|
| 1 | Prenotazione confermata | Candidato | ✅ ON |
| 2 | Prenotazione cancellata | Candidato | ✅ ON |
| 3 | Nuova prenotazione | Admin | ⬜ OFF |
| 4 | Cancellazione prenotazione | Admin | ⬜ OFF |
| 5 | Supervisore assegnato | Admin/Supervisore | ⬜ OFF |
| 6 | Supervisore rimosso | Admin/Supervisore | ⬜ OFF |
| 7 | Avviso sessione senza supervisore (domani) | Admin | ✅ ON |

✅ **Placeholder disponibili in tutti i template**

```
{site_name}           – Nome del sito WordPress
{candidate_name}      – Nome e cognome del candidato
{candidate_email}     – Email del candidato
{course_title}        – Titolo del corso Tutor LMS
{session_date}        – Data della sessione (formattata)
{session_time}        – Orario della sessione (HH:MM)
{session_id}          – ID univoco della sessione
{manage_booking_url}  – Link alla pagina gestione prenotazione
{booking_page_url}    – Link alla pagina di prenotazione
{proctor_name}        – Nome del supervisore assegnato
```

✅ **Esempio template email conferma prenotazione**
```
Soggetto: Esame confermato per {course_title}

Corpo:
Ciao {candidate_name},

La tua prenotazione è confermata!

📅 Data: {session_date}
⏰ Ora: {session_time}
📚 Corso: {course_title}

Gestisci la tua prenotazione: {manage_booking_url}

In bocca al lupo!
— {site_name}
```

---

### 7️⃣ Impostazioni – 5 schede di configurazione

**Tab 1: Shortcodes**
- Guida rapida all'uso degli shortcode
- Istruzioni di configurazione
- Funzionalità copia-in-clipboard

**Tab 2: Prenotazioni esami**
- `anticipo_ore_prenotazione` – ore di anticipo minimo per prenotarsi (0–720, default: 48)
- `consenti_annullamento` – abilita/disabilita la cancellazione
- `annullamento_ore` – ore minime prima dell'esame entro cui è consentita la cancellazione (0–720, default: 48)

**Tab 3: Accesso corsi**
- Abilita/disabilita il gate Tutor LMS
- Lead time (minuti prima dell'esame per sbloccare il corso)
- Scadenza prenotazione (valore + unità: ore o minuti; 0 = mai)
- Selezione corsi da gatare
- Selezione corsi nel dropdown di prenotazione

**Tab 4: Email**
- Nome e indirizzo mittente
- Destinatari admin (uno o più, separati da virgola)
- Destinatari notifiche calendario
- Toggle ON/OFF per ciascuno dei 7 tipi di email
- Editor soggetto + corpo per ogni template

**Tab 5: Pagine**
- Dropdown con ricerca per selezionare la pagina di prenotazione
- Dropdown con ricerca per selezionare la pagina di gestione prenotazione

---

### 8️⃣ Shortcode di riepilogo – Base

| Shortcode | Destinatario | Funzione |
|-----------|-------------|----------|
| `[mcems_book_exam]` | Candidati loggati | Calendario prenotazione esami |
| `[mcems_manage_booking]` | Candidati loggati | Visualizza e cancella prenotazioni |
| `[mcems_bookings_list]` | Admin / Staff | Lista prenotazioni con filtri e export CSV |
| `[mcems_sessions_calendar]` | Admin / Supervisori | Calendario assegnazione supervisori |

---

## 🌟 Funzionalità Premium – Versione avanzata

### 🔓 Limiti eliminati – Scala quanto vuoi

| Feature | Base | Premium |
|---------|------|---------|
| Sessioni future attive | **max 5** | **Illimitate** |
| Posti per sessione | **max 5** | **fino a 500** |
| Orari per giorno per sessione | **1** | **Multipli** |

Con Premium puoi generare centinaia di sessioni in un click e gestire platee di candidati di qualsiasi dimensione.

---

### 📊 Lista prenotazioni avanzata – Report professionali

**Shortcode**: `[mcems_bookings_list]`

In Premium, questo shortcode sostituisce la versione base con funzionalità avanzate.

✅ **Filtri professionali**
- 📅 **Data singola** o **range di date** (da–a) con toggle modalità avanzata
- 📚 **Filtro per corso** – seleziona uno o tutti i corsi
- I filtri si combinano liberamente

✅ **Tabella risultati**

| Cognome | Nome | Email | ID Sessione | Data | Ora | Corso | Speciale | Supervisore |
|---------|------|-------|-------------|------|-----|-------|----------|-------------|

✅ **Esportazione CSV**
- UTF-8 BOM per compatibilità Excel
- Nome file automatico: `exam_bookings_{data/range}_{corso}.csv`
- Include tutti i campi della tabella

**Caso d'uso tipico**:
> Admin vuole il report completo del corso "Patente ECDL" per tutto il mese di marzo → seleziona corso + range 1–31 marzo → esporta CSV → invia al direttore. Operazione completata in 30 secondi.

---

### ⚡ Funzionalità avanzate sessioni in Premium

✅ **Orari multipli per giorno**
- In Base è possibile inserire 1 solo orario per giorno
- In Premium si possono aggiungere più fasce orarie nella stessa giornata (es: 09:00, 14:00, 17:00)

✅ **Sessioni speciali avanzate**
- Le sessioni speciali (accessibilità) sono disponibili anche in Base
- In Premium non ci sono limiti di quota che si sommino con le sessioni normali

---

## 📊 Tabella comparativa completa Base vs Premium

| Feature | Base | Premium |
|---------|:----:|:-------:|
| **GESTIONE SESSIONI** | | |
| Custom Post Type sessioni esame | ✅ | ✅ |
| Generazione batch sessioni | ✅ | ✅ |
| Sessioni speciali (accessibilità) | ✅ | ✅ |
| Ricerca candidato per email (AJAX) | ✅ | ✅ |
| Sessioni passate in read-only | ✅ | ✅ |
| Aggiornamento capienza bulk | ✅ | ✅ |
| **Sessioni future max** | **5** | **Illimitate** 🚀 |
| **Posti per sessione max** | **5** | **500** 🚀 |
| **Orari per giorno** | **1** | **Multipli** 🚀 |
| **PRENOTAZIONI** | | |
| Calendario prenotazione frontend | ✅ | ✅ |
| Codice colore disponibilità | ✅ | ✅ |
| Anticipo prenotazione configurabile | ✅ | ✅ |
| Prevenzione doppia prenotazione | ✅ | ✅ |
| Supporto multi-corso per candidato | ✅ | ✅ |
| Integrazione Google Calendar | ✅ | ✅ |
| Gestione prenotazione candidato | ✅ | ✅ |
| Cancellazione con deadline configurabile | ✅ | ✅ |
| Storico prenotazioni passate | ✅ | ✅ |
| **ACCESSO CORSI** | | |
| Gate Tutor LMS (prenotazione richiesta) | ✅ | ✅ |
| Lead time (sblocco anticipato) | ✅ | ✅ |
| Scadenza prenotazione configurabile | ✅ | ✅ |
| Bypass admin/istruttori automatico | ✅ | ✅ |
| Selezione corsi da gatare | ✅ | ✅ |
| **CALENDARIO SUPERVISORI** | | |
| Calendario assegnazione supervisori | ✅ | ✅ |
| Riassegnazione/rimozione supervisore | ✅ | ✅ |
| Avviso 24h sessioni senza supervisore | ✅ | ✅ |
| **EMAIL** | | |
| 7 tipi di notifica email | ✅ | ✅ |
| Template soggetto/corpo personalizzabili | ✅ | ✅ |
| 10 placeholder dinamici | ✅ | ✅ |
| Mittente e destinatari configurabili | ✅ | ✅ |
| Toggle ON/OFF per ogni tipo email | ✅ | ✅ |
| **LISTA PRENOTAZIONI** | | |
| Lista con filtro data singola | ✅ | ✅ |
| Lista con filtro range di date | ❌ | ✅ 🌟 |
| Filtro per corso | ✅ | ✅ |
| Export CSV (Excel-compatible) | ✅ | ✅ |
| Modalità avanzata filtri toggle | ❌ | ✅ 🌟 |

---

## 💡 Casi d'uso reali

### 📚 Università con 500+ studenti

> **Problema**: Gestire 20 corsi con sessioni d'esame mensili. L'ufficio segreteria è sommerso da email e spreadsheet.
>
> **Soluzione** (Base → Premium):
> - Crea in batch 30+ sessioni per ciascun corso in pochi click
> - Candidati si prenotano dal sito senza contattare la segreteria
> - Email automatiche riducono il lavoro amministrativo dell'80%
> - Il gate Tutor LMS garantisce che solo chi ha prenotato accede al corso
> - Report mensili in CSV pronti per il direttore in 30 secondi
>
> **Risultato**: ⏱️ 15 ore/mese di lavoro amministrativo risparmiate

---

### 🏢 Centro di formazione professionale

> **Problema**: I candidati si dimenticano l'orario dell'esame; i supervisori non sanno chi devono seguire.
>
> **Soluzione**:
> - Email di conferma automatica al momento della prenotazione
> - Email di avviso 24h all'admin se una sessione del giorno dopo non ha supervisore
> - Calendario supervisori visibile dal frontend
>
> **Risultato**: 📉 80% in meno di no-show e sessioni senza supervisore

---

### 🎓 Scuola online con requisiti di accessibilità

> **Problema**: Alcuni candidati necessitano di sessioni individuali con strumenti ausiliari; il processo manuale è lento e soggetto a errori.
>
> **Soluzione**:
> - Sessioni speciali (♿) con capienza = 1
> - Ricerca candidato per email e assegnazione diretta dal backend
> - Badge visivo nella lista per tracciamento immediato
>
> **Risultato**: 🤝 Inclusività garantita senza processi separati

---

### 📊 Azienda certificatrice con audit requisiti

> **Problema**: Il cliente richiedente vuole prova documentale delle sessioni d'esame e dei candidati.
>
> **Soluzione** (Premium):
> - Esporta CSV filtrato per data range e corso
> - Tabella con cognome, nome, email, ID sessione, data, ora, supervisore
> - Sessioni passate in read-only: i dati storici non possono essere alterati
>
> **Risultato**: 📋 Audit trail completo sempre disponibile, conformità garantita

---

## 🎁 Vantaggi chiave per il tuo business

| Vantaggio | Impatto concreto |
|-----------|-----------------|
| **Automazione prenotazioni** | ⏰ Risparmio 8–15 ore/mese per la segreteria |
| **Interfaccia intuitiva** | 📱 Zero training per i candidati |
| **Scalabilità** | 🚀 Da 10 a 10.000 studenti senza riprogettare nulla |
| **Gate intelligente** | 🔒 Accesso corsi garantito solo a chi ha prenotato |
| **Sessioni speciali** | ♿ Accessibilità integrata, non un ripensamento |
| **Google Calendar sync** | 📅 I candidati non dimenticano più l'esame |
| **Email personalizzabili** | 💌 Ogni notifica porta il tuo brand |
| **Dati storici protetti** | 📋 Read-only automatico per audit e conformità |
| **Multi-corso per candidato** | 🎓 Un candidato, più corsi: tutto sotto controllo |
| **CSV export** | 📊 Report pronti in un click, compatibili con Excel |

---

## 📋 Piano di migrazione tipico

### ✅ Settimana 1 – Setup iniziale

- [ ] Installa MC-EMS Base (e opzionalmente Premium)
- [ ] Crea una pagina "Prenota esame" con shortcode `[mcems_book_exam]`
- [ ] Crea una pagina "Gestisci prenotazione" con shortcode `[mcems_manage_booking]`
- [ ] Vai in **Impostazioni → MC-EMS → Pagine** e collega le due pagine
- [ ] Configura il mittente email e i destinatari admin nella scheda **Email**
- [ ] Personalizza i template email con nome del tuo istituto

### ✅ Settimana 2 – Test e verifica

- [ ] Crea 2–3 sessioni di test dal menu **Exam Management System → Crea sessioni**
- [ ] Effettua una prenotazione di prova come candidato di test
- [ ] Verifica che le email di conferma arrivino correttamente
- [ ] Testa il gate Tutor LMS su un corso reale
- [ ] Verifica la cancellazione prenotazione e la relativa email

### ✅ Settimana 3 – Go-live

- [ ] Crea le sessioni reali per tutti i corsi
- [ ] Comunica ai candidati il link al calendario di prenotazione
- [ ] Assegna i supervisori dal calendario admin
- [ ] Monitora le prime prenotazioni e aggiusta le impostazioni se necessario

### ✅ Settimana 4+ – Ottimizzazione

- [ ] Analizza i dati con la lista prenotazioni (e CSV export in Premium)
- [ ] Regola anticipo prenotazione e scadenza cancellazione in base all'utilizzo reale
- [ ] Valuta l'upgrade a Premium se le sessioni attive superano il limite di 5

---

## 🔒 Sicurezza e conformità

✅ **Protezioni built-in**
- Validazione nonce su tutte le azioni AJAX
- Sanitizzazione input e escaping output conformi agli standard WordPress
- Sessioni passate in read-only: impossibile modificare dati storici per errore o maliziosamente
- Bypass automatico solo per ruoli verificati (admin, istruttore Tutor LMS)

✅ **Integrità dei dati**
- Ogni prenotazione è tracciata nel meta utente con timestamp di creazione
- Storico prenotazioni mantenuto separatamente dalle prenotazioni attive
- Migrazione automatica delle chiavi meta legacy per retrocompatibilità

✅ **Standard WordPress**
- Segue le WordPress Coding Standards
- Nessuna dipendenza da librerie esterne non verificate
- Uninstall pulito: rimuove le opzioni di configurazione (i dati dei post non sono eliminati automaticamente)

✅ **Conformità GDPR**
- Dati candidati gestiti tramite i meta utente WordPress standard
- Export dati facilmente ottenibile tramite CSV
- Possibilità di anonimizzare eliminando le prenotazioni utente prima della disinstallazione

---

## ⚙️ Requisiti tecnici

| Componente | Versione minima |
|-----------|----------------|
| WordPress | 6.0+ |
| PHP | 7.0+ |
| Tutor LMS | Qualsiasi versione recente |

---

## 📦 Struttura del plugin

```
mc-ems-base/              ← Plugin principale (versione gratuita)
├── mc-ems.php            ← Bootstrap, v2.4.2-base
├── includes/
│   ├── class-mcems-settings.php          ← Pannello impostazioni (5 tab)
│   ├── class-mcems-cpt-sessioni-esame.php ← Custom Post Type sessioni
│   ├── class-mcems-booking.php           ← Prenotazioni frontend + AJAX
│   ├── class-mcems-bookings-list.php     ← Lista prenotazioni + CSV
│   ├── class-mcems-calendar-sessioni.php ← Calendario supervisori
│   ├── class-mcems-admin-sessioni.php    ← Generazione sessioni backend
│   ├── class-mcems-tutor-gate.php        ← Gate accesso corsi Tutor LMS
│   ├── class-mcems-tutor.php             ← Integrazione Tutor LMS
│   ├── class-mcems-admin-banner.php      ← Banner admin Mamba Coding
│   ├── class-ems-session-id-column.php   ← Colonna ID sessione
│   └── class-mcems-upgrader.php          ← Migrazioni database
└── assets/

mc-ems-premium/           ← Add-on Premium (richiede Base attivo)
├── mc-ems-premium.php    ← Bootstrap, v2.2.6.4-premium
└── includes/
    └── class-mcems-bookings-list.php     ← Lista prenotazioni avanzata
```

---

## 🚀 Come iniziare subito

### Versione Base (gratuita)

1. Installa e attiva **MC-EMS Base**
2. Crea una pagina con `[mcems_book_exam]` e una con `[mcems_manage_booking]`
3. Vai in **Exam Management System → Impostazioni → Pagine** e seleziona le pagine create
4. Crea le prime sessioni d'esame dal menu **Exam Management System → Crea sessioni**
5. Invita i candidati al link del calendario di prenotazione ✨

### Upgrade a Premium

6. Installa e attiva **MC-EMS Premium** (richiede Base attivo)
7. Crea pagina con `[mcems_bookings_list]` per la lista prenotazioni avanzata
8. Crea sessioni illimitate e abilita orari multipli per giorno

---

## 📞 Supporto e documentazione

- 📖 **Documentazione tecnica**: vedere `mc-ems-base/README.md` e `mc-ems-base/CHANGELOG.md`
- 🐛 **Segnalazioni bug e richieste**: aprire un issue nel repository
- 💬 **Base**: risposta entro 48 ore
- ⚡ **Premium**: supporto prioritario, risposta entro 24 ore

---

**MC-EMS: Esami semplici. Gestione facile. Candidati felici. 🎓**

*Trasforma il tuo LMS in un vero centro esami professionale. Oggi stesso.*

---

*Realizzato da [Mamba Coding](https://mambacoding.com) · Plugin attivamente sviluppato e mantenuto*
