# MC-EMS – Exam Management System

**MC-EMS** is a WordPress plugin that adds a full exam session management system to your site: custom post types for exam slots, a candidate booking calendar, proctor assignment, and Tutor LMS course-gate integration.

---

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Features](#features)
- [Shortcodes](#shortcodes)
- [Admin Features](#admin-features)
- [Email Customization](#email-customization)
- [Troubleshooting](#troubleshooting)
- [FAQ](#faq)
- [Developer Notes](#developer-notes)
- [Changelog](#changelog)
- [License](#license)

---

## Requirements

| Requirement | Minimum version |
|-------------|----------------|
| WordPress   | 6.0+           |
| PHP         | 7.0+           |

---

## Installation

### Manual installation

1. Download the plugin as a ZIP file.
2. In your WordPress admin go to **Plugins → Add New → Upload Plugin**.
3. Select the ZIP file and click **Install Now**.
4. Activate the plugin.

### Post-activation setup

1. Create a **Booking** page and add the shortcode `[mcems_book_exam]`.
2. Create a **Manage Booking** page and add the shortcode `[mcems_manage_booking]`.
3. Go to **Settings → MC-EMS → Pages** and assign both pages.
4. (Optional) Configure email notifications under **Settings → MC-EMS → Email**.

---

## Features

### Exam Session Management (CPT)
- Custom post type `slot_esame` for exam sessions.
- Set date, time, location, capacity, and course association per session.
- Past sessions are automatically locked as read-only in the backend.

### Candidate Booking Calendar
- Logged-in users can browse available exam slots on an interactive calendar.
- One active booking per user is enforced.
- Candidates can cancel their booking from the management page.

### Proctor Assignment Calendar
- Admin-only calendar for assigning proctors to exam sessions.
- Search users by email to quickly assign a proctor.

### Tutor LMS Integration
- Gate course access based on active exam bookings.
- Automatically grants or revokes access when booking status changes.

### Email Notifications
- Booking confirmation email to the candidate.
- Booking cancellation email to the candidate.
- Admin notification on new bookings.
- Proctor assignment notification.
- All subjects and bodies are fully customizable with placeholders.

### Premium Features *(MC-EMS Premium)*
- Full exam bookings list (`[mcems_bookings_list]` shortcode).
- Advanced reporting and export.

---

## Shortcodes

### `[mcems_book_exam]`

Displays the exam booking calendar. Logged-in users can select and book an available exam slot.

**Usage:**
```
[mcems_book_exam]
```

Place this shortcode on your designated booking page.

---

### `[mcems_manage_booking]`

Shows the currently logged-in user's active booking with the option to cancel it.

**Usage:**
```
[mcems_manage_booking]
```

---

### `[mcems_sessions_calendar]`

Displays the admin proctor assignment calendar. Intended for administrator use only — restrict page access accordingly.

**Usage:**
```
[mcems_sessions_calendar]
```

---

### `[mcems_bookings_list]` *(Premium)*

Lists all exam bookings with filtering and export options. Available only with **MC-EMS Premium**.

---

## Admin Features

### Settings → MC-EMS → Pages
Assign the pages where booking and manage-booking shortcodes are placed.

### Settings → MC-EMS → Exam Booking
- Enable/disable exam booking.
- Set maximum bookings per session.
- Configure booking open/close windows.

### Settings → MC-EMS → Email
- Toggle individual email notifications (booking confirmation, cancellation, admin alerts, proctor assignment).
- Set sender name and sender email address.
- Define admin recipient email addresses.
- Customize subject lines and body text using placeholders (see [Email Customization](#email-customization)).

### Exam Sessions (CPT)
Navigate to **Exam Sessions** in the admin sidebar to create, edit, and manage exam session posts. Past sessions are locked and displayed as read-only.

---

## Email Customization

Use the following placeholders in email subject and body fields:

| Placeholder | Description |
|-------------|-------------|
| `{candidate_name}` | Full name of the booking candidate |
| `{candidate_email}` | Email address of the candidate |
| `{exam_date}` | Date of the exam session |
| `{exam_time}` | Time of the exam session |
| `{exam_location}` | Location of the exam session |
| `{course_title}` | Title of the associated course |
| `{proctor_name}` | Name of the assigned proctor |
| `{site_name}` | Name of the WordPress site |

---

## Troubleshooting

**Booking calendar is empty / shows no slots**
- Ensure at least one `Exam Session` post exists with a future date and available capacity.
- Check that the booking page has the `[mcems_book_exam]` shortcode.

**Users cannot see the booking page**
- The plugin requires users to be logged in to book an exam. Make sure users are authenticated.

**Emails are not being sent**
- Verify that WordPress can send email (test with a plugin like WP Mail SMTP).
- Check **Settings → MC-EMS → Email** to confirm the relevant notifications are toggled on.

**Tutor LMS course access not working**
- Ensure Tutor LMS is installed and activated.
- Verify the exam session is linked to the correct course.

**Settings are not saving**
- Check for permission issues; you need `manage_options` capability.
- Verify there are no caching plugins interfering with admin requests.

---

## FAQ

**Can a user book multiple exam sessions?**
No. The plugin enforces one active booking per user. Users must cancel their current booking before booking a new session.

**What happens to bookings when the plugin is uninstalled?**
On uninstall, the plugin removes its option records. It does **not** delete `slot_esame` posts automatically, so your booking data is preserved.

**Is MC-EMS compatible with page builders?**
Yes. Shortcodes work with any page builder that supports standard WordPress shortcodes (Elementor, Divi, Beaver Builder, etc.).

**How do I show the bookings list to admins?**
The full bookings list is a **Premium** feature available via `[mcems_bookings_list]` with MC-EMS Premium.

**Can I translate the plugin?**
Yes. The plugin is fully localization-ready. Place `.po`/`.mo` files in the `/languages` directory with the `mc-ems` text domain.

---

## Developer Notes

### File Structure

```
mc-ems-base-fix/
├── assets/
│   ├── images/
│   └── js/
│       └── booking.js
├── includes/
│   ├── class-ems-session-id-column.php
│   ├── class-nfems-admin-banner.php
│   ├── class-nfems-admin-sessioni.php
│   ├── class-nfems-booking.php
│   ├── class-nfems-bookings-list.php
│   ├── class-nfems-calendar-sessioni.php
│   ├── class-nfems-cpt-sessioni-esame.php
│   ├── class-nfems-settings.php
│   ├── class-nfems-tutor-gate.php
│   ├── class-nfems-tutor.php
│   └── class-nfems-upgrader.php
├── languages/
├── CHANGELOG.md
├── README.md
├── mc-ems.php
└── uninstall.php
```

### Hooks & Filters

The plugin runs its main bootstrap on the `plugins_loaded` action. All classes are initialized inside this hook to ensure WordPress is fully loaded before plugin code runs.

### Contributing

1. Fork the repository.
2. Install development dependencies: `composer install`.
3. Run code standards check: `composer phpcs`.
4. Auto-fix code style issues: `composer phpcbf`.
5. Submit a pull request with a clear description of your changes.

---

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for the full version history.

---

## License

This plugin is released under the [GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html) license.
