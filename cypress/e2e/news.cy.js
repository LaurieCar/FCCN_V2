/* describe('Accueil FCCN - Affichage des actualités', () => {
  it('doit afficher la section Actualités du club', () => {
    cy.visit('http://127.0.0.1:8001');

    // test titre de la section
    cy.contains('NOS ACTUALITÉS').should('be.visible');

    // test vérification au moins une actualité est affichée
    cy.get('article').should('have.length.greaterThan', 0);

    // test vérification titre, contenu, image et date s'affiche pour chaque news
    cy.get('article').first().within(() => {
      cy.get('img').should('exist');
      cy.get('h3').should('not.be.empty');
      cy.get('p').should('not.be.empty');
      cy.get('span').should('not.be.empty');
    })
  })
}) */