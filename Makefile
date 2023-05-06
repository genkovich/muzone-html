production-deploy:
	gh act --secret-file ./.github/.secrets -W ./.github/workflows/build_and_test.yaml

secrets-prod:
	sops --encrypt -pgp E6FE7CAC5630586D4EF174D641D470C354AFC756 .env.prod.local > .env.local.sops