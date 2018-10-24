# The Cleaning Robot Test Assignment

## Requirements

Latest docker, docker-compose.

Could test only on linux (Ubuntu 18.04.1).

## Installation

Run ``bin/build`` from the project's root directory.

Add **cleaning-robot.local** address to your hosts file like:

```
127.0.0.1 cleaning-robot.local
```

## Running

Run ``bin/start`` from the project's root directory.

### Running console command

Run ``bin/command robot:run <source> <result>`` from the project's root directory.

It will use <projectDir>/src as root directory, so
```
bin/command.sh robot:run tests/data/test1.json result.json
```
would take <projectDir>/src/tests/data/test1.json as the source and produce the output in the <projectDir>/src/result.json file. 

### Running REST API

Send POST request to cleaning-robot.local/robot/clean

```
curl -XPOST http://cleaning-robot.local:8080/robot/run -H "Content-Type:application/json" --data "@src/tests/data/test1.json"
```

### Running Tests

Run ``bin/tests`` from the project's root directory.
