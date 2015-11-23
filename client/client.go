package main

import (
    "fmt"
    "bytes"
    "github.com/gorilla/rpc/v2/json2"
    "log"
    "net/http"
    "os"
)

type Result struct {

    CountryDiallingCode int

    CountryIdentifier string

    MnoIdentifier string

    SubscriberNumber string

    Valid bool
}

func main() {
    url := "http://192.168.33.10:8000/index.php"

    var params [1]string
    params[0] = os.Args[1]

    message, err := json2.EncodeClientRequest("parse", params)
    if err != nil {
        log.Fatalf("%s", err)
    }

    req, err := http.NewRequest("POST", url, bytes.NewBuffer(message))
    if err != nil {
        log.Fatalf("%s", err)
    }

    req.Header.Set("Content-Type", "application/json")
    client := new(http.Client)
    resp, err := client.Do(req)
    if err != nil {
        log.Fatalf("Error in sending request to %s. %s", url, err)
    }
    defer resp.Body.Close()

    var result Result

    err = json2.DecodeClientResponse(resp.Body, &result)
    if err != nil {
        log.Fatalf("Couldn't decode response. %s", err)
    }

    fmt.Printf("Input number: %s\n", params[0])
    fmt.Printf("Number valid: %t\n", result.Valid)
    if result.Valid == true {
        fmt.Printf("Country dialing code: %d\n", result.CountryDiallingCode)
        fmt.Printf("Country identifier: %s\n", result.CountryIdentifier)
        fmt.Printf("MNO identifier: %s\n", result.MnoIdentifier)
        fmt.Printf("Subscriber number: %s\n", result.SubscriberNumber)
    }
}
