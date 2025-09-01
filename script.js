fetch('evenements.json')
  .then(response => response.json())
  .then(events => {
    const container = document.getElementById('events');
    events.forEach(event => {
      container.innerHTML += `
        <h3>${event.title}</h3>
        <p>${event.date}</p>
        <p>${event.description}</p>
        <img src="${event.image}" alt="${event.title}" width="300">
      `;
    });
  });
