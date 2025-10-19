# Changelog

All notable changes to the ITS NU Pekalongan Lost & Found System will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Development Team

This project was developed by:
- **Ahsanu Rohmatika Taqwa**
- **Hasan Mahfudh**
- **Abiyyul Asyqor**

As part of the Final Year Project (FYP) requirement at ITS NU Pekalongan.

## [Unreleased] - Latest Updates

### Added
- Complete Indonesian language translation for all user interface elements
- Enhanced map marker system with real-time database integration
- Robust error handling for Google Vision API and Mapbox integration
- Admin logging enhancements with IP address and user agent tracking
- Fallback mechanisms for missing API keys and database errors
- Comprehensive debugging system for map and data transfer issues

### Changed
- UI theme updated to green branding matching ITS NU Pekalongan identity
- Map integration switched to Leaflet.js with OpenStreetMap/Mapbox support
- Navbar styling and positioning completely redesigned
- Admin panel interface improved with proper image handling

### Fixed
- **Critical Map Issues**: Fixed missing red/green markers on home page map
- **UI Layout Problems**: Resolved navbar overlap with map and content areas
- **Database Integration**: Fixed data transfer issues between PHP controller and JavaScript
- **Image Display**: Corrected image paths in admin panel and item detail pages
- **Popup Positioning**: Fixed modal popups being covered by navbar
- **API Error Handling**: Added graceful fallbacks for Google Vision API failures
- **Security Issues**: Fixed unauthorized delete button access and improved admin moderation
- **Database Errors**: Resolved array-to-string conversion and SQL parameter binding issues

## [1.0.0] - 2025-10-14

### Added
- Initial release of the ITS NU Pekalongan Lost & Found System
- Complete rebranding from the original UiTM version
- All core functionality retained from original project
- Enhanced documentation and installation guides
- Updated branding and institutional references

### Changed
- Institution name updated throughout the application
- Email domains updated to reflect ITS NU Pekalongan
- Repository references updated
- Default credentials updated for ITS NU Pekalongan

### Removed
- All UiTM-specific branding and references
- Original UiTM email addresses
- UiTM-specific configuration values

## [0.1.0] - 2025-04-01

### Added
- Initial version based on UiTM Lost & Found System
- Core functionality for lost and found item management
- Student and admin authentication systems
- Interactive map integration
- Image recognition capabilities
- Claim management system
- Admin moderation features

[Unreleased]: https://github.com/your-username/lost-and-found-itsnupkl/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/your-username/lost-and-found-itsnupkl/compare/v0.1.0...v1.0.0
[0.1.0]: https://github.com/your-username/lost-and-found-itsnupkl/releases/tag/v0.1.0