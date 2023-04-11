#!/usr/bin/env bats

@test "Test index" {
    run rapper -q -i turtle -o ntriples http://localhost/.well-known/void.ttl
	[ $status -eq 0 ]
	[ ${#lines[@]} -eq 13 ]
}
