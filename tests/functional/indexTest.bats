#!/usr/bin/env bats

@test "Test index redirect" {
    run rapper -q -i turtle -o ntriples http://localhost/.well-known/void
	[ $status -eq 0 ]
	[ ${#lines[@]} -eq 13 ]
}

@test "Test index" {
    run rapper -q -i turtle -o ntriples http://localhost/void.ttl
	[ $status -eq 0 ]
	[ ${#lines[@]} -eq 13 ]
}
