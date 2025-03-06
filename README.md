# API Routes Documentation

## Books

### Add Tags to a Book
- **Endpoint:** `POST /books/actions/add-tag`
- **Controller:** `AddTagsController`
- **Description:** Adds a tag to a book.
- **Request Body:**
  ```json
  {
    "book_id": 123,
    "tag": "fiction"
  }
  ```
- **Response:**
  ```json
  {
    "message": "Tag added successfully"
  }
  ```

### Import Books
- **Endpoint:** `POST /books/importBooks`
- **Controller:** `importBooksController`
- **Description:** Imports a list of books from an external source.
- **Request Body:**
  ```json
  {
    "books": [
      { "title": "Book Title", "author": "Author Name" }
    ]
  }
  ```
- **Response:**
  ```json
  {
    "message": "Books imported successfully"
  }
  ```

### Get Distinct Tags
- **Endpoint:** `GET /books/tags`
- **Controller:** `GetDistinctTagsController`
- **Description:** Retrieves a list of all distinct book tags.
- **Response:**
  ```json
  {
    "tags": ["fiction", "mystery", "sci-fi"]
  }
  ```

### Search Books
- **Endpoint:** `GET /books/search/{search}/{qty}`
- **Controller:** `GetBooksBySearch`
- **Description:** Searches for books based on a query string and returns a limited quantity.
- **Parameters:**
    - `search` (string): The search term.
    - `qty` (integer): The number of results to return.
- **Response:**
  ```json
  {
    "books": [
      { "id": 1, "title": "Example Book" }
    ]
  }
  ```

### Get All Books by Filter
- **Endpoint:** `GET /books/filter`
- **Controller:** `GetAllBooksController`
- **Description:** Retrieves all books based on specified filters.
- **Query Parameters:**
    - Optional filters like `author`, `subject`, `tag` , etc.
- **Response:**
  ```json
  {
    "books": [
      { "id": 1, "title": "Filtered Book" }
    ]
  }
  ```

### Get Book by ID
- **Endpoint:** `GET /book/{id}`
- **Controller:** `GetBooksByID`
- **Description:** Retrieves a book by its unique ID.
- **Parameters:**
    - `id` (integer): The book ID.
- **Response:**
  ```json
  {
    "id": 1, "title": "Example Book", "author": "John Doe"
  }
  ```

### Get Tags for a Book
- **Endpoint:** `GET /book/{id}/tags`
- **Controller:** `GetTagsController`
- **Description:** Retrieves all tags associated with a specific book.
- **Parameters:**
    - `id` (integer): The book ID.
- **Response:**
  ```json
  {
    "tags": ["fiction", "adventure"]
  }
  ```

### Delete a Tag from a Book
- **Endpoint:** `DELETE /delete/tags/{id}/{tag}`
- **Controller:** `DeleteTagController`
- **Description:** Deletes a specific tag from a book.
- **Parameters:**
    - `id` (integer): The book ID.
    - `tag` (string): The tag to be deleted.
- **Response:**
  ```json
  {
    "message": "Tag removed successfully"
  }
  ```

## Categories

### Get All Categories
- **Endpoint:** `GET /categories`
- **Controller:** `GetCategoriesController`
- **Description:** Retrieves all book categories.
- **Response:**
  ```json
  {
    "categories": ["Fiction", "Non-fiction", "Biography"]
  }
  ```





## Install the Application

Create a new directory with your project name, e.g:


```bash
mkdir academyProject
```

Once inside the new directory, clone this repo:

```bash
git clone git@github.com:Mayden-Academy/subscriptionsAssistant.git .
```

One cloned, you must install the slim components by running:

```bash
composer install
```

To run the application locally:
```bash
composer start

```

Import '/public/subscriptions_test_database_2025-01-06.sql'


Run this command in the application directory to run the test suite
```bash
composer test
```

That's it! Now go build something cool.
