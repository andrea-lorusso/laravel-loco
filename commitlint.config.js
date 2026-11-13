// Keep the type list aligned with .github/hooks/commit-msg.
export default {
    extends: ['@commitlint/config-conventional'],
    rules: {
        'type-enum': [2, 'always', ['feat', 'fix', 'refactor', 'perf', 'style', 'test', 'docs', 'build', 'ops', 'chore']],
        'subject-case': [0],
        'body-max-line-length': [0],
        'footer-max-line-length': [0],
    },
};
