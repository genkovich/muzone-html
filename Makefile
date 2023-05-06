production-deploy:
	gh act --secret-file ./.github/.secrets -W ./.github/workflows/build_and_test.yaml

secrets-prod:
	sops --encrypt -pgp 2F3679D6CEB3F4F86C7E6E75A0B210E152DEA3FC .env.prod.local > .env.local.sops