# Guanchishan fork releases

This fork uses a fourth numeric version component: `1.1.1.1` is fork revision 1
based on upstream 1.1.1. The next fork revision is `1.1.1.2`. After rebasing onto
upstream 1.1.2, start at `1.1.2.1`. PHP/WordPress version comparison orders
`1.1.1 < 1.1.1.1 < 1.1.1.2 < 1.1.2`.

GitHub release tags use `guanchishan-v1.1.1.1`, keeping the fork's tag names
separate from upstream. The plugin Version header and README Stable tag use
only the numeric version. The fork release workflow builds an installable ZIP
with production Composer dependencies and a SHA-256 checksum. It never deploys
to WordPress.org; the inherited WordPress.org workflow is restricted to the
upstream repository.

For an upstream PR, include the privacy fix commit and omit the fork version
and release automation commit. Anonymous Cook pages now return a non-cacheable
404; users must sign in through the site's own login entry first.

Version naming does not disable WordPress.org updates. If you want to retain
the fork while upstream releases are reviewed, leave automatic updates off
for Cook App and review upstream updates before installing them.
