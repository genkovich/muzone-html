production-deploy:
	gh act --secret-file ./.github/.secrets -W ./.github/workflows/build_and_test.yaml

secrets-prod:
	sops --encrypt -pgp D96B520D8A5821A52C480E3660834B88C66E98E9 .env.prod.local > .env.local.sops