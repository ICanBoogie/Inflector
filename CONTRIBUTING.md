# Contributing

Contributions are **welcome** and will be fully **credited**.

We accept contributions via Pull Requests.

## Pull Requests

- **Code style** — We're following a [Coding Standard][]. Check the code style with `make lint`.
- **Code health** — We're using [PHPStan][] to analyse the code, with maximum scrutiny. Check the code with `make lint`.
- **Add tests!** — Your contribution won't be accepted if it does not have tests.
- **Document any change in behaviour** — Make sure the `README.md` and any other relevant documentation are kept
  up-to-date.
- **Consider our release cycle** — We follow [SemVer v2.0.0](http://semver.org/). Randomly breaking public APIs is not
  an option.
- **Create feature branches** — We won't pull from your main branch.
- **One pull request per feature** — If you want to do more than one thing, send multiple pull requests.
- **Send coherent history** — Make sure each individual commit in your pull request is meaningful. If you had to make
  multiple intermediate commits while developing, please [squash them][git-squash] before submitting.

## Running Tests

We provide a Docker container for local development. Run `make test-container` to create a new session. Inside the
container run `make test` to run the test suite. Alternatively, run `make test-coverage` for a breakdown of the code
coverage. The coverage report is available in `build/coverage/index.html`.

**Thanks for your contribution**!


[Coding Standard]: phpcs.xml
[git-squash]: http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages
[PHPStan]: https://phpstan.org/user-guide/getting-started
