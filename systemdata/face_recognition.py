import face_recognition
import urllib.request
import argparse

arg_parser = argparse.ArgumentParser(description='')
arg_parser.add_argument('--img1url', help='URL of first image to be compared')
arg_parser.add_argument('--img2url', help='URL of second image to be compared')
args = arg_parser.parse_args()
known_image = face_recognition.load_image_file(urllib.request.urlopen(args.img1url))
unknown_image = face_recognition.load_image_file(urllib.request.urlopen(args.img2url))
biden_encoding = face_recognition.face_encodings(known_image)[0]
unknown_encoding = face_recognition.face_encodings(unknown_image)[0]
results = face_recognition.compare_faces([biden_encoding], unknown_encoding)
for item in results:
	print(item)
