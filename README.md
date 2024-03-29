# Lemuria

Lemuria ist ein „Play-by-eMail", wird also über E-Mail gespielt, und ist
inspiriert durch Eressea und Fantasya.

Der Programmcode ist in Bibliotheken aufgeteilt. Diese Bibliothek beinhaltet ein
Datenmodell des Lemuria-Spiels, das ähnlich zu dem von Fantasya ist.

## Ähnlichkeiten zu Eressea et al.

Lemuria ist in manchen Aspekten ähnlich zu Eressea und Fantasya.

### Die Spielpartei

Jeder Spieler besitzt _Einheiten_, die in ihrer Gesamtheit die _Partei_ des
Spielers bilden. Einheiten sind identifizierbar, lernen Talente, können wachsen
und schrumpfen und mittels Anwendung der Talente Spielaktionen ausführen wie das
Ernten von Rohstoffen, das Produzieren und Bauen von Gegenständen und Gebäuden,
oder das Führen von Kämpfen mit Waffen.

### Regionen und Spielwelt

Einheiten können durch die Spielwelt bewegt werden, die aus vielen _Regionen_
mit
unterschiedlichen Landschaften wie Gebirgen, Wälder, Ebenen oder Ozeanen
besteht. Die Landschaft einer Region beeinflusst das Vorhandensein von
Ressourcen und entwickelt sich im Laufe der Zeit weiter.

Regionen sind in einer Karte angeordnet, und Einheit bewegen sich zwischen ihnen
zu Fuß oder durch das Reiten von Tieren und das Reisen mit Wagen oder Schiffen.

## Unterschiede

Lemuria fügt den von Eressea et al. geerbten Konzepten weitere Aspekte hinzu.

### Erweiterte Diplomatie

Die Beziehungen zu anderen Parteien können detaillierter eingestellt werden. Zum
einen gibt es feinere Möglichkeiten für die Gewährung von Rechten wie Übergaben,
Besteuerung, Kampfbündnisse etc., zum anderen können die Rechte auch auf
einzelne Regionen beschränkt werden, und es ist möglich, allgemeingültige
Einstellungen für alle Fremdparteien zu treffen (sozusagen eine
"parteifreundliche Grundhaltung").

#### Beziehungen

- COMBAT: Unterstützt angegriffene Fremdeinheiten.
- DISGUISE: Hebt die Parteitarnung gegenüber der Fremdpartei auf.
- EARN: Erlaubt Einkünfte durch Besteuerung oder Unterhaltung.
- ENTER: Erlaubt das Betreten von Gebäuden und Schiffen.
- FOOD: Gibt Almosen (Nahrung oder Silber) an hungernde Fremdeinheiten.
- GIVE: Nimmt Geschenke von der Fremdpartei an.
- GUARD: Erlaubt der Fremdpartei die Weiterreise nach Betreten einer Region.
- PASS: Erlaubt die Durchreise durch eine bewachte Region.
- PERCEPTION: Unsichtbare Einheiten verstecken sich nicht vor der Fremdpartei.
- RESOURCES: Erlaubt den Abbau von Ressourcen.
- SILVER: Erlaubt Fremdeinheiten den Zugriff auf den Silberpool.
- TELL: Dies bewirkt, dass die eigene Partei der Fremdpartei beim Erstkontakt
  "allgemeine Auskünfte" über sich gibt. Die Fremdpartei nimmt diplomatische
  Beziehungen auf und erhält eine Kontaktadresse.
- TRADE: Der Fremdpartei wird das Handeln erlaubt.
