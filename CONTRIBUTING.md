# Contributing to ITS NU Pekalongan Lost & Found System

Thank you for your interest in contributing to the ITS NU Pekalongan Lost & Found System! We welcome contributions from the community to help improve and enhance this project.

## Code of Conduct

By participating in this project, you are expected to uphold our Code of Conduct. Please report unacceptable behavior to the project maintainers.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check the existing issues as you might find out that you don't need to create one. When you are creating a bug report, please include as many details as possible:

- **Use a clear and descriptive title** for the issue
- **Describe the exact steps** which reproduce the problem
- **Provide specific examples** to demonstrate the steps
- **Describe the behavior you observed** after following the steps
- **Explain which behavior you expected** to see instead
- **Include screenshots** if possible
- **Note the version** of the application you're using

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, please include:

- **Use a clear and descriptive title** for the issue
- **Provide a step-by-step description** of the suggested enhancement
- **Provide specific examples** to demonstrate the steps
- **Describe the current behavior** and **explain which behavior you expected** to see instead
- **Explain why this enhancement** would be useful to most users

### Pull Requests

- Fill in the required template
- Do not include issue numbers in the PR title
- Include screenshots and animated GIFs in your pull request when possible
- Follow the PHP and JavaScript styleguides
- Include thoughtfully-worded, well-structured tests
- Document new code based on existing documentation standards
- End all files with a newline

## Styleguides

### Git Commit Messages

- Use the present tense ("Add feature" not "Added feature")
- Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit the first line to 72 characters or less
- Reference issues and pull requests liberally after the first line
- When only changing documentation, include `[ci skip]` in the commit title

### PHP Styleguide

All PHP code must adhere to [PSR-12](https://www.php-fig.org/psr/psr-12/) standards.

### JavaScript Styleguide

All JavaScript code must adhere to [Airbnb JavaScript Style Guide](https://github.com/airbnb/javascript).

### CSS Styleguide

All CSS code must adhere to [Airbnb CSS Style Guide](https://github.com/airbnb/css).

## Development Setup

1. Fork the repository
2. Clone your fork
3. Install dependencies with `composer install` and `npm install`
4. Set up your environment with `cp .env.example .env` and `php artisan key:generate`
5. Create a database and configure your `.env` file
6. Run migrations with `php artisan migrate`
7. Seed the database with `php artisan db:seed`
8. Build frontend assets with `npm run build`

## Testing

- Write tests for new features
- Ensure all tests pass before submitting a pull request
- Run tests with `php artisan test`

## Documentation

- Update the README.md with details of changes to the interface
- Update existing documentation to reflect changes
- Add new documentation for new features

## Additional Notes

### Issue and Pull Request Labels

This section lists the labels we use to help organize and identify issues and pull requests.

- `bug` - Issues that are bugs
- `enhancement` - Issues that are feature requests
- `documentation` - Issues or pull requests related to documentation
- `good first issue` - Good for newcomers
- `help wanted` - Extra attention is needed
- `question` - Further information is requested

Thank you for contributing to the ITS NU Pekalongan Lost & Found System!