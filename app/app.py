from flask import Flask, request, jsonify
import psycopg2

app = Flask(__name__)

def get_db_connection():
    return psycopg2.connect(
        host='db',
        dbname='testdb',
        user='postgres',
        password='postgres'
    )

@app.route('/add', methods=['POST'])
def add_entry():
    data = request.json
    conn = get_db_connection()
    cur = conn.cursor()
    cur.execute("INSERT INTO entries (content) VALUES (%s)", (data['content'],))
    conn.commit()
    cur.close()
    conn.close()
    return jsonify({'status': 'added'})

@app.route('/entries', methods=['GET'])
def get_entries():
    conn = get_db_connection()
    cur = conn.cursor()
    cur.execute("SELECT * FROM entries")
    rows = cur.fetchall()
    cur.close()
    conn.close()
    return jsonify(rows)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
