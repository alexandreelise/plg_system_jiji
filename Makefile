.PHONY: gen help

.DEFAULT_GOAL= gen

CURRENT_DIR=$$(pwd)
CURRENT_DATETIME=$$(date +%Y%m%d%H%M)
BUILD_DIR=$$(pwd)

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

gen: ./src ## Create extension zip file
	mkdir -p $(BUILD_DIR)/build \
	&& cd $(CURRENT_DIR)/src \
	&& find . -type f -name "*.php" -exec php -l "{}" \; \
	&& zip -9 -r $$(dirname $(BUILD_DIR))/build/$$(basename $$(dirname $(CURRENT_DIR)))_$(CURRENT_DATETIME).zip . \
	&& cd ..

