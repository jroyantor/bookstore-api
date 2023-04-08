# Bookstore API 

- [Get Token](#get-authorization-token)
- [Get All Books](#get-all-books)
- [Get a single Book](#get-a-single-book)
- [Add a new Book](#add-book-information)
- [Update a Book Information](#update-book-information)
- [Delete a book](#delete-book)
- [Get All Genres](#get-all-genres)
- [Get Genre by ID](#get-genre-information)
- [Update Genre Information](#update-genre)
- [Delete a genre](#delete-from-genre)

Click on each link to get details.

## Get Authorization Token

***Request Method and URL***

```
GET api.example-bookstore.com/get_token
Accept: application/json
```

***Request Body***


```
JSON

{
    "name":"user_name",
    "password":"user_password"
}
```

***Response***

```
JSON

{
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwiZXhwIjoxNjgwODk0MDYzfQ.FRMnVylUez8RNZ90alrJ8hxp9fvoc5GRGDNKIU2M-Ww"
}
```
## Get All Books

***Request Method and URL with headers***

```
GET api.example-bookstore.com/books
Accept: application/json
Authorization: Bearer token
```

***Response***

```
JSON

[
    {
        "title": "1984",
        "author": "George Orwell",
        "excerpt": "Among the seminal texts of the 20th century, Nineteen Eighty-Four is a rare work that grows more haunting as its futuristic purgatory becomes more real. Published in 1949, the book offers political satirist George Orwell's nightmarish vision of a totalitarian, bureaucratic world and one poor stiff's attempt to find individuality.",
        "price": "800",
        "is_available": false,
        "genre": "Fiction"
    },
    {
        "title": "Animal Farm",
        "author": "George Orwell",
        "excerpt": "A farm is taken over by its overworked, mistreated animals. With flaming idealism and stirring slogans, they set out to create a paradise of progress, justice, and equality. Thus the stage is set for one of the most telling satiric fables ever penned –a razor-edged fairy tale for grown-ups that records the evolution from revolution against tyranny to a totalitarianism just as terrible.",
        "price": "800",
        "is_available": false,
        "genre": "Fiction"
    },
    {
        "title": "Sapiens",
        "author": "Yuval Noah Harari",
        "excerpt": "In Sapiens, Dr Yuval Noah Harari spans the whole of human history, from the very first humans to walk the earth to the radical – and sometimes devastating – breakthroughs of the Cognitive, Agricultural and Scientific Revolutions. Drawing on insights from biology, anthropology, paleontology and economics, he explores how the currents of history have shaped our human societies, the animals and plants around us, and even our personalities. Have we become happier as history has unfolded? Can we ever free our behaviour from the heritage of our ancestors? And what, if anything, can we do to influence the course of the centuries to come?",
        "price": "800",
        "is_available": false,
        "genre": "Non-fiction"
    },
    {
        "title": "A Brief History of Time",
        "author": "Stephen Hawking",
        "excerpt": "Was there a beginning of time? Could time run backwards? Is the universe infinite or does it have boundaries?\r\nThese are just some of the questions considered in the internationally acclaimed masterpiece by the world renowned physicist - generally considered to have been one of the world's greatest thinkers. It begins by reviewing the great theories of the cosmos from Newton to Einstein, before delving into the secrets which still lie at the heart of space and time, from the Big Bang to black holes, via spiral galaxies and strong theory. To this day A Brief History of Time remains a staple of the scientific canon, and its succinct and clear language continues to introduce millions to the universe and its wonders.",
        "price": "800",
        "is_available": false,
        "genre": "Non-fiction"
    },
    {
        "title": "Of Human Bondage",
        "author": "William Somerset Maugham",
        "excerpt": "  Originally published in 1915, Of Human Bondage is a potent expression of the power of sexual obsession and of modern man's yearning for freedom. This classic bildungsroman tells the story of Philip Carey, a sensitive boy born with a clubfoot who is orphaned and raised by a religious aunt and uncle. Philip yearns for adventure, and at eighteen leaves home, eventually pursuing a career as an artist in Paris. When he returns to London to study medicine, he meets the androgynous but alluring Mildred and begins a doomed love affair that will change the course of his life. There is no more powerful story of sexual infatuation, of human longing for connection and freedom.",
        "price": "800",
        "is_available": false,
        "genre": "Fiction"
    },
    {
        "title": "The Trial",
        "author": "Franz Kafka",
        "excerpt": "Written in 1914 but not published until 1925, a year after Kafka’s death, The Trial is the terrifying tale of Josef K., a respectable bank officer who is suddenly and inexplicably arrested and must defend himself against a charge about which he can get no information. Whether read as an existential tale, a parable, or a prophecy of the excesses of modern bureaucracy wedded to the madness of totalitarianism, The Trial has resonated with chilling truth for generations of readers.",
        "price": "50",
        "is_available": true,
        "genre": "Fiction"
    }
]
```

## Get A Single Book

***Request Method and URL with headers***

```
GET api.example-bookstore.com/books/{id}
Accept: application/json
Authorization: Bearer token
```

***Sample Response***

```
JSON

{
    "title": "1984",
    "author": "George Orwell",
    "excerpt": "Among the seminal texts of the 20th century, Nineteen Eighty-Four is a rare work that grows more haunting as its futuristic purgatory becomes more real. Published in 1949, the book offers political satirist George Orwell's nightmarish vision of a totalitarian, bureaucratic world and one poor stiff's attempt to find individuality.",
    "price": "800",
    "is_available": false,
    "genre": "Fiction"
}
```


## Add Book Information

***Request Method and URL with headers***

```
POST api.example-bookstore.com/books
Accept: application/json
Authorization: Bearer token
```

***Request Body***

```
JSON

{
    "title": "Klara and the Sun",
    "author": "Kazuo Ishiguro",
    "excerpt": "From her place in the store, Klara, an Artificial Friend with outstanding observational qualities, watches carefully the behavior of those who come in to browse, and of those who pass on the street outside. She remains hopeful that a customer will soon choose her, but when the possibility emerges that her circumstances may change forever, Klara is warned not to invest too much in the promises of humans.In Klara and the Sun, Kazuo Ishiguro looks at our rapidly changing modern world through the eyes of an unforgettable narrator to explore a fundamental question: what does it mean to love?",
    "price": "900",
    "is_available": true,
    "genre_id":3
}
```

***Response***


```
JSON

{
    "message": "New book info added",
    "id": {id}
}

```

## Update Book Information

***Request Method and URL with headers***

```
PATCH api.example-bookstore.com/books/{id}
Accept: application/json
Authorization: Bearer token
```

***Response***

```
JSON

{
    "message": "Book {id} updated.",
    "rows": "1 rows affected"
}
```

## Delete Book Information

***Request Method and URL with headers***

```
DELETE api.example-bookstore.com/books/{id}
Accept: application/json
Authorization: Bearer token
```

***Response***
```
JSON

{
    "message": "Book {id} deleted",
    "rows": "1 affected"
}
```

## Get All Genres

***Request Method and URL with headers***

```
GET api.example-bookstore.com/genres
Accept: application/json
Authorization: Bearer token
```

***Response***

```
JSON

[
    {
        "id": 1,
        "name": "Adventure",
        "description": "Genre for anything related to adventure.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
    },
    {
        "id": 2,
        "name": "Biography",
        "description": "Genre for anything related to biography.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
    },
    {
        "id": 3,
        "name": "Fiction",
        "description": "Genre for anything related to fiction.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
    },
    {
        "id": 4,
        "name": "History",
        "description": "Genre for anything related to history.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
    },
    {
        "id": 5,
        "name": "Mystery",
        "description": "Genre for anything related to mystery.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
    },
    {
        "id": 6,
        "name": "Horror",
        "description": "Genre for anything related to horror.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
    },
    {
        "id": 7,
        "name": "Non-fiction",
        "description": "Genre for anything related to nonfiction.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
    },
    {
        "id": 8,
        "name": "Poetry",
        "description": "Genre for anything related to poetry.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
    },
    {
        "id": 9,
        "name": "Science Fiction",
        "description": "Genre for anything related to science fiction.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
    },
    {
        "id": 10,
        "name": "Fantasy",
        "description": "Fiction with strange or other worldly settings or characters.",
        "created_at": "2023-03-21 20:50:37",
        "updated_at": "2023-03-21 20:50:37"
    }
]
```

## Get Genre Information

***Request Method and URL with headers***

```
GET api.example-bookstore.com/genres/{id}
Accept: application/json
Authorization: Bearer token
```
  

***Response***
```
JSON

{
        "id": 1,
        "name": "Adventure",
        "description": "Genre for anything related to adventure.",
        "created_at": "2020-11-16 11:58:12",
        "updated_at": "2020-11-16 11:58:12"
}

```

## Add genre

***Request Method and URL with headers***

```
POST api.example-bookstore.com/genres
Accept: application/json
Authorization: Bearer token
```

***Request Body***

```
JSON

{
    "name":"Science Fiction",
    "description": "Science fiction (abbreviated SF or sci-fi with varying punctuation and capitalization) is a broad genre of fiction that often involves speculations based on current or future science or technology. Science fiction is found in books, art, television, films, games, theatre, and other media."
}
```

***Response***

```
JSON

{
    "message": "New genre info added",
    "id": {id}
}
```


## Update Genre 

***Request Method and URL with header***

```
PATCH api.example-bookstore.com/genres/{id}
Accept: application/json
Authorization: Bearer token
```

***Request Body***


```
JSON

{
    "name":"Updated genre name",
    "description":"Updated description"
}
```

***Sample Response***


```
JSON

{
    "message": "Genre {id} updated.",
    "rows": "1 rows changed"
}
```



## Delete From Genre

***Request Method and URL with headers***

```
DELETE api.example-bookstore.com/genres/{id}
Accept: application/json
Authorization: Bearer token
```

***Response***

```
JSON

{
    "message": "Genre {id} deleted",
    "rows": "1 rows changed"
}
```
