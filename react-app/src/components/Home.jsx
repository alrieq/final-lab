import React, { useState, useEffect } from 'react';
const apiUrl = 'http://localhost:9000/php-server/api';

export default function App() {
  const [title, setTitle] = useState('');
  const [link, setLink] = useState('');
  const [bookmarkId, setBookmarkId] = useState('');
  const [bookmarks, setBookmarks] = useState([]);
  useEffect(() => {
    fetchAllBookmarks();
  }, []);

  const fetchAllBookmarks = async () => {
    try {
      const response = await fetch(`${apiUrl}/readAll.php`);
      const data = await response.json();
      setBookmarks(data);
    } catch (error) {
      console.error('Failed to fetch bookmarks:', error);
    }
  };
  const handleAddBookmark = async () => {
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ title, link }),
    };

    try {
      const response = await fetch(`${apiUrl}/create.php`, options);
      if (response.ok) {
        console.log('Bookmark added successfully!');
      } else {
        console.error('Failed to add bookmark:', response.statusText);
      }
    } catch (error) {
      console.error('Failed to add bookmark:', error);
    }
  };

  const handleDeleteBookmark = async () => {
    const options = {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
      },
    };

    try {
      const response = await fetch(`${apiUrl}/delete.php?id=${bookmarkId}`, options);
      if (response.ok) {
        console.log('Bookmark deleted successfully!');
      } else {
        console.error('Failed to delete bookmark:', response.statusText);
      }
    } catch (error) {
      console.error('Failed to delete bookmark:', error);
    }
  };

  const handleUpdateBookmark = async () => {
    const options = {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ title }),
    };

    try {
      const response = await fetch(`${apiUrl}/update.php?id=${bookmarkId}`, options);
      if (response.ok) {
        console.log('Bookmark updated successfully!');
      } else {
        console.error('Failed to update bookmark:', response.statusText);
      }
    } catch (error) {
      console.error('Failed to update bookmark:', error);
    }
  };

  return (
    <div>
      <h1>Bookmark Management</h1>
      <div>
        <h2>Add Bookmark</h2>
        <input
          type="text"
          placeholder="Title"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
        />
        <input
          type="text"
          placeholder="URL"
          value={link}
          onChange={(e) => setLink(e.target.value)}
        />
        <button onClick={handleAddBookmark}>Add</button>
      </div>
      <div>
        <h2>Update/Delete Bookmark</h2>
        <input
          type="text"
          placeholder="Bookmark ID"
          value={bookmarkId}
          onChange={(e) => setBookmarkId(e.target.value)}
        />
        <button onClick={handleUpdateBookmark}>Update Title</button>
        <button onClick={handleDeleteBookmark}>Delete</button>
      </div>
      <div>
        <h2>All Bookmarks</h2>
        <ul>
          {bookmarks.map((bookmark) => (
            <li key={bookmark.id}>
              <strong>Title:</strong> {bookmark.title}, <strong>Link:</strong> {bookmark.link}
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
}