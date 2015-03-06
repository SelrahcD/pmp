Feature: quote
  As a member
  I can create a quote from an itinerary

Scenario:
 Given that I'm a member
 Given that itinerary "Bretagne Sud" exists
 When I ask for a quote for itinerary "Bretagne Sud"
 Then a quote is created for me and references itinerary "Bretagne Sud" 