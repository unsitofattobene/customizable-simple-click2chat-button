# Customizable Simple Click2Chat Button

A lightweight, performance-first WordPress plugin that adds a fully customizable floating WhatsApp chat button to your website — letting visitors reach you with a single click.

**No JavaScript. No external requests. No bloat.**

---

## ✨ Features

- 🎨 **Fully customizable colors** — bubble, handset, and ring can each be styled independently
- 💬 **Pre-filled message** — define the text that appears in the user's chat
- 📍 **Flexible positioning** — top/bottom, left/right, with pixel-perfect offset
- 📐 **Adjustable icon size**
- 📱 **Per-device visibility** — show or hide on desktop, tablet, or mobile
- 👀 **Live preview** in the admin panel, with a dark-background toggle
- ⚡ **Zero JavaScript on the frontend** — pure HTML + CSS, inline SVG
- 🌍 **Translation-ready** — Italian translation included
- 🧹 **Smart cache handling** — auto-purges cache on save (WP Rocket, LiteSpeed, WP Super Cache, W3 Total Cache, WP Fastest Cache, Autoptimize, SG Optimizer)

---

## 📦 Installation

### From this repository

1. Download the latest `.zip` from the [Releases page](../../releases)
2. In your WordPress admin, go to **Plugins → Add New → Upload Plugin**
3. Select the downloaded `.zip` and click **Install Now**
4. Activate the plugin
5. Go to **Click2Chat** in the admin menu and configure it

### Manual installation

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate it from the **Plugins** menu in WordPress
3. Configure under **Click2Chat**

---

## ⚙️ Configuration

1. Enter your phone number with international prefix, no spaces or `+` sign
   *Example:* `39333123456`
2. Write your pre-filled message (optional)
3. Choose colors, position, size, and device visibility
4. Save — cache is purged automatically

---

## ❓ FAQ

**How do I enter the phone number?**
Use the full number with international prefix, no spaces, dashes, or `+`. For example: `39333123456`.

**Can I customize the message?**
Yes — use the "Pre-filled message" field.

**Does it slow down my site?**
No. The plugin loads no JavaScript on the frontend, makes no extra HTTP requests, and uses an inline SVG. Performance impact is essentially zero.

---

## 📋 Requirements

- WordPress **5.2** or higher
- PHP **7.2** or higher
- Tested up to WordPress **6.9**

---

## 📝 Changelog

### 1.2
- Removed deprecated `load_plugin_textdomain()` call (translations are now loaded automatically by WordPress)

### 1.1
- Added "Customize" action link in the plugins list for quick access
- Automatic page cache purge on settings save
- Cache warning notice below the save button
- Fixed shadow not showing in admin preview on page load
- Changed default shadow color to `#787878`
- Added dark background toggle in admin preview
- Added notice about phone number requirement
- Added Italian translations for all new strings

### 1.0
- Initial release

---

## 📄 License

Released under the [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html) license.

## 👤 Author

Made with ❤️ by [Niccolai Viola](https://www.unsitofattobene.it)
