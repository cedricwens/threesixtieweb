#Beschrijving van het algoritme

# Algoritme #

  * Alle mogelijke polls invullen in de database.
  * Alle polls van eigen gebruikers + eigen teammanagers verwijderen.
  * Elke poll krijgt een score, die afkomstig is van de constraints.
  * Elke constraint heeft een bepaalde 'belangrijkheid'. Deze belangrijkheid stemt overeen met een bepaalde score.
  * Score is niet exact, maar is een interval (bv 0-5). Als een bepaalde poll dan een score krijgt van een bepaalde constraint, dan wordt deze score random uit de 'scoreverzameling' van deze constraint gehaald. Op deze manier zit er al een randomize functie in verwerkt, waardoor het bepalden van de koppels op het einde van het algortime makkelijker is.
  * Zodra alle constraints overlopen zijn voor alle polls, wordt berekend wat de gemiddelde score is voor 1 poll, en wat het gemiddelde geprefereerde reviewers/reviewees is per gebruiker.
  * Deze score wordt dan gebruikt om te controleren ofdat deze 'batch' van polls een voldoende hoge score heeft.
  * Indien niet kan het algortime opnieuw berekend worden