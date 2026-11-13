<?php

namespace Tests\Feature;

use Tests\TestCase;

class AppVersionTest extends TestCase
{
    public function test_app_version_matches_version_file(): void
    {
        $this->assertSame(
            trim((string) file_get_contents(base_path('VERSION'))),
            config('app.version'),
        );
    }

    public function test_app_version_is_semver(): void
    {
        $this->assertMatchesRegularExpression('/^\d+\.\d+\.\d+(-[0-9A-Za-z.-]+)?$/', config('app.version'));
    }
}
