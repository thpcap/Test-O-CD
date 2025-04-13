# Test-O-CD

## Objectif du projet :

Projet réalisé lors de la candidature à un stage dans l'entreprise OC'D.

## Partie 2 : Commentaires

Ce type de fonctionnalité, impliquant de grandes quantités de données, est proche des problématiques rencontrées dans le domaine du **Big Data**.

Dans ce cas, il serait plus judicieux d'utiliser des outils adaptés au traitement de données massives, comme un cluster de calcul distribué (par exemple, **Hadoop** ou **Apache Spark**). Ces technologies permettent de :
- Gérer efficacement de grandes quantités de données.
- Effectuer des calculs parallèles pour accélérer le traitement des degrés de parenté.
- Assurer une scalabilité horizontale pour répondre à une augmentation du nombre d'utilisateurs.

Ces outils sont particulièrement adaptés pour des systèmes nécessitant un traitement rapide et fiable des données à grande échelle.

---

## Partie 3

## 1 : Schéma de la base de données
[Schéma de la base de données](https://dbdiagram.io/d/67fbeaf94f7afba1846b9c36)

---

## 2 : Évolution des données pour les cas "Propositions de Modifications" et "Validation des Modifications"

### Cas 1 : Propositions de Modifications

1. **Insertion d'une proposition** :
   - Lorsqu'un utilisateur propose une modification (par exemple, ajouter une relation ou modifier une fiche), une entrée est ajoutée dans la table `modification_proposals`.
   - Exemple d'insertion :
     ```sql
     INSERT INTO modification_proposals (proposed_by, type_id, target_person_id, related_person_id, payload, status)
     VALUES (3, 1, 5, 2, '{"relation": "parent"}', 'pending');
     ```
   - Cela enregistre une proposition de type `add_relation` entre la personne `5` et la personne `2`.

2. **Notification des utilisateurs** :
   - Les utilisateurs concernés (par exemple, ceux liés à la fiche ou à la relation) sont notifiés via l'interface utilisateur pour examiner la proposition.

---

### Cas 2 : Validation des Modifications

1. **Vote sur une proposition** :
   - Lorsqu'un utilisateur examine une proposition, il peut voter pour l'accepter ou la refuser. Chaque vote est enregistré dans la table `modification_proposal_votes`.
   - Exemple d'insertion d'un vote :
     ```sql
     INSERT INTO modification_proposal_votes (proposal_id, voted_by, vote, reason)
     VALUES (1, 4, 'accepted', 'Relation correcte');
     ```

2. **Mise à jour du statut de la proposition** :
   - Une fois qu'une proposition atteint 3 votes (nombre possiblement configurable avec la table config) "acceptés" ou "rejetés", son statut est mis à jour dans la table `modification_proposals`.
   - Exemple de mise à jour :
     ```sql
     UPDATE modification_proposals
     SET status = 'accepted', resolved_at = NOW()
     WHERE id = 1;
     ```

3. **Application de la modification** :
   - Si la proposition est acceptée :
     - Les modifications sont appliquées à la base de données (par exemple, ajout d'une relation dans `relationships` ou mise à jour d'une fiche dans `people`).
     - Exemple d'ajout d'une relation :
       ```sql
       INSERT INTO relationships (parent_id, child_id)
       VALUES (5, 2);
       ```
   - Si la proposition est rejetée :
     - Aucune modification n'est appliquée, et la proposition est marquée comme "rejected".

---

