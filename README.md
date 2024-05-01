# Blueauth

## Live demo: https://blanka.lol/validation/bsky.php

## Overview
This is a custom authentication system designed for Bluesky, a social media platform, allowing users to verify their ownership of an account. The system generates a unique random string for each user, which they must post on their Bluesky account for validation.

## Components
- **Frontend**: 
  - HTML, CSS (Bootstrap), and JavaScript are used for the user interface.
  - Users input their Bluesky handle and are guided through the verification process.
  - Feedback alerts provide information on the verification status.

- **Backend**:
  - `bsky-api-string.php`: Generates a random string associated with the user's Bluesky handle.
  - `bsky-api-auth.php`: Validates the ownership of the account by comparing the posted string with the generated one.

## Usage
1. **Input Bluesky Handle**: Users enter their Bluesky handle in the provided field.
2. **Generate Random String**: Upon submission, a unique random string is generated and displayed.
3. **Post on Bluesky**: Users post the generated string on their Bluesky account for verification.
4. **Validation**: The system validates the ownership based on the posted string.
5. **Feedback**: Users receive immediate feedback on the validation status through alerts.

## Technologies Used
- HTML, CSS (Bootstrap), JavaScript for frontend development.
- PHP for backend handling of string generation and authentication.
- cURL for making requests to Clippsly to Bluesky API bridge.

## Note
- **Backend Integration**: Ensure proper integration and configuration of the backend scripts (`bsky-api-string.php` and `bsky-api-auth.php`) for the system to function correctly.
- **Security**: Implement security measures, such as input validation and sanitization, to prevent vulnerabilities like SQL injection and cross-site scripting (XSS).
- **Testing**: Thoroughly test the system in various scenarios to ensure reliability and security.

This system provides a basic framework for Bluesky authentication and can be extended and customized according to specific requirements and security considerations.

Built with love by Blanka in Poland 💜
