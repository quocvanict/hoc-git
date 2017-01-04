SRC_DIR = src
TEST_DIR = tests
PHPUNIT ?= vendor/bin/phpunit
PHPCS ?= vendor/bin/phpcs

PREFIX = .
DIST_DIR = ${PREFIX}/dist
PLY = Polyline.php

GMPET = ${DIST_DIR}/${PLY}
SRC_GMPET = ${SRC_DIR}/${PLY}
NAMESPACE_GMPET = ${DIST_DIR}/emcconville/${PLY}

GMPET_VER = $(shell git describe)
GMPET_DATE = $(shell git log -1 --date=short --pretty=format:%ad)

all: lint polyline test goodbye

${DIST_DIR}:
	@@mkdir -p ${DIST_DIR}

clean:
	@@echo "Removing polyline build: " ${DIST_DIR}
	@@rm -rf ${DIST_DIR}

goodbye:
	@@echo "Build complete"

polyline: ${SRC_GMPET} | ${DIST_DIR}
	@@echo "Building Polyline"
	@@cat ${SRC_GMPET} | \
		sed 's/@VERSION@/'"${GMPET_VER}"'/' | \
		sed 's/@DATE@/'"${GMPET_DATE}"'/' > ${GMPET};

namespace: polyline
	@@echo "Patching namespace"
	@@mkdir -p ${DIST_DIR}/emcconville
	@@cat ${GMPET} | \
		sed 's/^\/\/@NAMESPACE@\s*//g' > ${NAMESPACE_GMPET}

test:
	@@echo "Testing Polyline"
	@@if test ! -z ${PHPUNIT}; then \
		${PHPUNIT} --testdox ; \
	else \
		echo "PHPUnit not installed. Skipping build test."; \
	fi

coverage:
	@@echo "Generating Code-Coverage report"
	@@if test ! -z ${PHPUNIT}; then \
		${PHPUNIT} --coverage-text ; \
	else \
		echo "PHPUnit not installed. Skipping build test."; \
	fi

lint:
	@@echo "Scanning source files"
	@@if test ! -z ${PHPCS}; then \
		${PHPCS} --standard=phpcs-ruleset.xml src tests examples; \
	else \
		echo "PHPCS not installed. Skipping lint."; \
	fi

.PHONY: all clean goodbye polyline namespace test coverage lint
